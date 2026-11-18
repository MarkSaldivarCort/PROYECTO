<?php
namespace App\Console\Commands;

use App\Models\AlertaSuricata;
use App\Models\AuditoriaExportacion;
use App\Models\BloqueoExportacion;
use App\Models\SuricataImportState;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        if (
            !$ssh->login(
                config('services.suricata.username'),
                config('services.suricata.password')
            )
        ) {
            $this->error('No se pudo conectar por SSH.');
            return self::FAILURE;
        }

        $rutas = [
            '/var/log/suricata/eve.json.1',
            '/var/log/suricata/eve.json',
        ];

        $sidsPermitidos = [
            1000001,
            1000002,
            1000003,
            1000004,
            1000005,
        ];

        $firmasPermitidas = [
            'RRHH-DLP Posible extraccion masiva de empleados',
            'RRHH-DLP Exportacion de multiples RFC sin enmascarar',
            'RRHH-DLP Consulta masiva de fichas de empleados',
            'RRHH-DLP Posible SQL Injection',
            'RRHH-DLP Exportacion de empleados fuera del horario laboral',
        ];

        $eventosLeidos = 0;
        $alertasGuardadas = 0;
        $descartadasPorSid = 0;
        $descartadasPorFirma = 0;
        $descartadasPorHorario = 0;
        $duplicadas = 0;
        $huboErrores = false;

        foreach ($rutas as $rutaArchivo) {

            $this->info("Procesando: {$rutaArchivo}");

            try {

                // Consultar inode y tamaño
                $metadatos = $ssh->exec(
                    "stat -c '%i %s' " .
                    escapeshellarg($rutaArchivo) .
                    " 2>/dev/null"
                );

                if ($metadatos === false || trim($metadatos) === '') {
                    $this->warn("Archivo no disponible: {$rutaArchivo}");
                    continue;
                }

                $datosArchivo = preg_split(
                    '/\s+/',
                    trim($metadatos)
                );

                if (count($datosArchivo) !== 2) {
                    throw new \RuntimeException(
                        'Metadatos iniciales inválidos.'
                    );
                }

                $inodeActual = (string) $datosArchivo[0];
                $tamanoActual = (int) $datosArchivo[1];

                // Recuperar estado independiente
                $estado = SuricataImportState::firstOrCreate(
                    ['file_path' => $rutaArchivo],
                    [
                        'file_inode' => null,
                        'file_offset' => 0,
                    ]
                );

                $offsetInicial = (int) $estado->file_offset;

                // Detectar reemplazo del archivo
                if (
                    $estado->file_inode !== null &&
                    (string) $estado->file_inode !== $inodeActual
                ) {
                    $offsetInicial = 0;
                }

                // Detectar truncamiento observable
                if ($tamanoActual < $offsetInicial) {
                    $offsetInicial = 0;
                }

                // Leer desde el último byte procesado
                $contenido = $ssh->exec(
                    'tail -c +' . ($offsetInicial + 1) .
                    ' ' . escapeshellarg($rutaArchivo)
                );

                if ($contenido === false || $contenido === null) {
                    throw new \RuntimeException(
                        'No se pudo leer el archivo.'
                    );
                }

                // Procesar solamente líneas completas
                $ultimoSalto = strrpos($contenido, "\n");

                if ($ultimoSalto === false) {
                    $lineas = [];
                    $bytesProcesados = 0;
                } else {
                    $contenidoCompleto = substr(
                        $contenido,
                        0,
                        $ultimoSalto + 1
                    );

                    $lineas = explode(
                        "\n",
                        rtrim($contenidoCompleto, "\n")
                    );

                    $bytesProcesados = strlen($contenidoCompleto);
                }

                // Procesar eventos
                foreach ($lineas as $linea) {

                    if (trim($linea) === '') {
                        continue;
                    }

                    $eventosLeidos++;

                    $evento = json_decode($linea, true);

                    if (
                        !is_array($evento) ||
                        json_last_error() !== JSON_ERROR_NONE
                    ) {
                        throw new \RuntimeException(
                            "JSON inválido en {$rutaArchivo}."
                        );
                    }

                    // Ignorar eventos que no sean alertas
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

                    // Convertir la fecha al horario de Ciudad de México
                    $fechaEvento = Carbon::parse(
                        $evento['timestamp']
                    )->setTimezone('America/Mexico_City');

                    // Evaluar horario solamente para el SID 1000005
                    if ((int) $sid === 1000005) {

                        $diaSemana = $fechaEvento->dayOfWeekIso;
                        $hora = $fechaEvento->format('H:i:s');

                        $fueraHorario = (
                            $diaSemana >= 6 ||
                            $hora < '08:00:00' ||
                            $hora >= '19:00:00'
                        );

                        if (!$fueraHorario) {
                            $descartadasPorHorario++;
                            continue;
                        }
                    }

                    $eventHash = hash('sha256', $linea);

                    // Procesar cada alerta de forma transaccional
                    $resultado = DB::transaction(function () use ($evento, $sid, $firma, $eventHash, $fechaEvento) {

                        $existente = AlertaSuricata::where(
                            'event_hash',
                            $eventHash
                        )->exists();

                        if ($existente) {
                            return 'duplicada';
                        }

                        $srcIp = $evento['src_ip'] ?? null;

                        AlertaSuricata::create([
                            'flow_id' => $evento['flow_id'] ?? null,
                            'src_ip' => $srcIp,
                            'dest_ip' => $evento['dest_ip'] ?? null,
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

                        // Asociar alerta con auditoría
                        if ((int) $sid === 1000001 && $srcIp) {

                            $auditoria = AuditoriaExportacion::where(
                                'ip',
                                $srcIp
                            )
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

                        return 'guardada';
                    });

                    if ($resultado === 'duplicada') {
                        $duplicadas++;
                    } else {
                        $alertasGuardadas++;
                    }
                }

                // Verificar que el archivo no cambió durante la lectura
                $metadatosFinales = $ssh->exec(
                    "stat -c '%i %s' " .
                    escapeshellarg($rutaArchivo) .
                    " 2>/dev/null"
                );

                if ($metadatosFinales === false || trim($metadatosFinales) === '') {
                    throw new \RuntimeException(
                        'No se pudieron verificar los metadatos finales.'
                    );
                }

                $datosFinales = preg_split(
                    '/\s+/',
                    trim($metadatosFinales)
                );

                $archivoSinCambios = (
                    count($datosFinales) === 2 &&
                    (string) $datosFinales[0] === $inodeActual &&
                    (int) $datosFinales[1] >= (
                        $offsetInicial + $bytesProcesados
                    )
                );

                if (!$archivoSinCambios) {
                    throw new \RuntimeException(
                        'El archivo cambió durante la lectura. Offset conservado.'
                    );
                }

                // Actualizar posición
                $estado->file_inode = $inodeActual;
                $estado->file_offset = (
                    $offsetInicial + $bytesProcesados
                );
                $estado->save();

                $this->info(
                    "Posición actualizada: {$rutaArchivo}"
                );

            } catch (Throwable $e) {

                $huboErrores = true;

                $this->error(
                    "Error en {$rutaArchivo}: " . $e->getMessage()
                );
            }
        }

        $this->info("Eventos leídos: {$eventosLeidos}");
        $this->info("Alertas guardadas: {$alertasGuardadas}");
        $this->info("Descartadas por SID: {$descartadasPorSid}");
        $this->info("Descartadas por firma: {$descartadasPorFirma}");
        $this->info("Descartadas por horario: {$descartadasPorHorario}");
        $this->info("Duplicadas: {$duplicadas}");
        

        return $huboErrores
            ? self::FAILURE
            : self::SUCCESS;
    }
}
