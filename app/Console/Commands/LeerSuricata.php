<?php

namespace App\Console\Commands;

use App\Models\AlertaSuricata;
use App\Models\AuditoriaExportacion;
use App\Models\BloqueoExportacion;
use App\Models\SuricataImportState;
use Illuminate\Console\Command;
use phpseclib4\Net\SSH2;
use Carbon\Carbon;
use Throwable;

class LeerSuricata extends Command
{
    protected $signature = 'suricata:leer';

    protected $description = 'Lee eventos de Suricata por SSH';
   
    public function handle()
    {
        $ssh = new SSH2(config('services.suricata.host'));

        if (!$ssh->login(
            config('services.suricata.username'),
            config('services.suricata.password')
        )) {
            $this->error('No se pudo conectar por SSH.');
            return self::FAILURE;
        }

        $rutaArchivo = '/var/log/suricata/eve.json';

        // Consultar inode y tamaño del archivo remoto
        $metadatos = $ssh->exec(
            "stat -c '%i %s' " . escapeshellarg($rutaArchivo)
        );

        if ($metadatos === false || trim($metadatos) === '') {
            $this->error('No se pudieron consultar los metadatos de eve.json.');
            return self::FAILURE;
        }

        $datosArchivo = preg_split('/\s+/', trim($metadatos));

        if (count($datosArchivo) !== 2) {
            $this->error('Los metadatos de eve.json no tienen el formato esperado.');
            return self::FAILURE;
        }

        $inodeActual = (string) $datosArchivo[0];
        $tamanoActual = (int) $datosArchivo[1];

        // Recuperar o crear el estado de importación
        $estado = SuricataImportState::firstOrCreate(
            ['file_path' => $rutaArchivo],
            [
                'file_inode' => null,
                'file_offset' => 0,
            ]
        );

        // Detectar si el archivo fue reemplazado o rotado
        if (
            $estado->file_inode !== null &&
            $estado->file_inode !== $inodeActual
        ) {
            $estado->file_offset = 0;
        }

        // Detectar si el archivo fue truncado
        if ($tamanoActual < $estado->file_offset) {
            $estado->file_offset = 0;
        }

        // Leer desde el último byte procesado
        $offsetInicial = (int) $estado->file_offset;

        $contenido = $ssh->exec(
            'tail -c +' . ($offsetInicial + 1) . ' ' .
            escapeshellarg($rutaArchivo)
        );

        if ($contenido === false || $contenido === null) {
            $this->error('No se pudo leer el contenido incremental de eve.json.');
            return self::FAILURE;
        }

        // Procesar únicamente líneas completas
        $ultimoSalto = strrpos($contenido, "\n");

        if ($ultimoSalto === false) {
            $lineas = [];
            $bytesProcesados = 0;
        } else {
            $contenidoCompleto = substr($contenido, 0, $ultimoSalto + 1);
            $lineas = explode("\n", rtrim($contenidoCompleto, "\n"));
            $bytesProcesados = strlen($contenidoCompleto);
        }

        $eventosLeidos = 0;
        $alertasGuardadas = 0;
        $descartadasPorSid = 0;
        $descartadasPorFirma = 0;
        $duplicadas = 0;

        $sidsPermitidos = [
            1000001,
            1000002,
            1000003,
            1000004,
        ];

        $firmasPermitidas = [
            'RRHH-DLP Posible extraccion masiva de empleados',
            'RRHH-DLP Exportacion de multiples RFC sin enmascarar',
            'RRHH-DLP Consulta masiva de fichas de empleados',
            'RRHH-DLP Posible SQL Injection',
        ];

        foreach ($lineas as $linea) {

            if (trim($linea) === '') {
            continue;
            }

            $eventosLeidos++;

            $evento = json_decode($linea, true);
            

            if (!is_array($evento)) {
                continue;
            }

            $eventHash = hash('sha256', $linea);

            if (
                ($evento['event_type'] ?? null) !== 'alert' ||
                !isset($evento['alert'])
            ) {
                continue;
            }

            $sid = $evento['alert']['signature_id'] ?? null;
            $firma = $evento['alert']['signature'] ?? '';

            if (!in_array((int) $sid, $sidsPermitidos, true)) {
                $descartadasPorSid++;
                continue;
            }

            if (!in_array($firma, $firmasPermitidas, true)) {
                $descartadasPorFirma++;
                continue;
            }

            if (empty($evento['timestamp'])) {
                continue;
            }

           $fechaEvento = Carbon::parse($evento['timestamp'])->setTimezone(config('app.timezone'));

            $flowId = $evento['flow_id'] ?? null;
            $srcIp = $evento['src_ip'] ?? null;
            $destIp = $evento['dest_ip'] ?? null;

            // Evitar duplicados mediante la huella digital del evento
            $alertaExistente = AlertaSuricata::where('event_hash', $eventHash)->first();

            if ($alertaExistente) {
                $duplicadas++;
            }

            try {
                // Guardar solamente si la alerta no existe
                if (!$alertaExistente) {
                    AlertaSuricata::create([
                        'flow_id' => $flowId,
                        'src_ip' => $srcIp,
                        'dest_ip' => $destIp,
                        'signature' => $firma,
                        'severity' => $evento['alert']['severity'] ?? null,
                        'sid' => $sid,
                        'fecha_evento' => $fechaEvento,
                        'event_type' => $evento['event_type'],
                        'http_method' => $evento['http']['http_method'] ?? null,
                        'http_url' => $evento['http']['url'] ?? null,
                        'http_status' => $evento['http']['status'] ?? null,
                        'event_hash' => $eventHash,
                    ]);

                    $alertasGuardadas++;
                }

                // Intentar asociar la alerta con una auditoría de exportación
                // Se ejecuta también cuando la alerta ya estaba registrada.
                if ((int) $sid === 1000001 && $srcIp) {
                    $auditoria = AuditoriaExportacion::where('ip', $srcIp)
                        ->whereNotNull('usuario_id')
                        ->whereBetween('created_at', [
                            $fechaEvento->copy()->subMinutes(10),
                            $fechaEvento->copy()->addSeconds(30),
                        ])
                        ->latest('created_at')
                        ->first();

                    if ($auditoria) {
                        $bloqueoActivo = BloqueoExportacion::where(
                            'usuario_id',
                            $auditoria->usuario_id
                        )
                            ->where('bloqueado_hasta', '>', now())
                            ->exists();

                        if (!$bloqueoActivo) {
                            BloqueoExportacion::create([
                                'usuario_id' => $auditoria->usuario_id,
                                'ip' => $srcIp,
                                'motivo' => 'Posible extracción masiva de empleados detectada por Suricata (SID 1000001)',
                                'bloqueado_hasta' => now()->addMinutes(10),
                            ]);
                        }
                    }
                }

            } catch (Throwable $e) {
                $this->error('Error al procesar alerta: ' . $e->getMessage());
            }
        }
        // Guardar la posición alcanzada en el archivo de Suricata
        $estado->file_inode = $inodeActual;
        $estado->file_offset = $offsetInicial + $bytesProcesados;
        $estado->save();

        $this->info("Eventos leídos: {$eventosLeidos}");
        $this->info("Alertas guardadas: {$alertasGuardadas}");
        $this->info("Descartadas por SID: {$descartadasPorSid}");
        $this->info("Descartadas por firma: {$descartadasPorFirma}");
        $this->info("Duplicadas: {$duplicadas}");

        return self::SUCCESS;
    }

}
