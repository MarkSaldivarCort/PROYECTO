<?php
namespace App\Console\Commands;

use App\Models\AlertaSuricata;
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
        $ssh = new SSH2(
            config('services.suricata.host')
        );

        if (!$ssh->login(
            config('services.suricata.username'),
            config('services.suricata.password')
        )) {
            $this->error('No se pudo conectar por SSH.');
            return self::FAILURE;
        }

        $contenido = $ssh->exec(
            'tail -n 100 /var/log/suricata/eve.json'
        );

        if ($contenido === false) {
            $this->error('No se pudo leer el archivo de Suricata.');
            return self::FAILURE;
        }

        $lineas = explode("\n", $contenido);
        $guardadas = 0;

        foreach ($lineas as $linea) {

            if (trim($linea) === '') {
                continue;
            }

            $evento = json_decode($linea, true);

            if (
                !is_array($evento) ||
                ($evento['event_type'] ?? null) !== 'alert'
            ) {
                continue;
            }

            $alerta = $evento['alert'] ?? [];

            if (!isset($evento['timestamp'])) {
                continue;
            }

            $datos = [
                'flow_id' => isset($evento['flow_id'])
                    ? (string) $evento['flow_id']
                    : null,

                'src_ip' => $evento['src_ip'] ?? null,

                'dest_ip' => $evento['dest_ip'] ?? null,

                'signature' => $alerta['signature'] ?? null,

                'severity' => $alerta['severity'] ?? null,

                'sid' => isset($alerta['signature_id'])
                    ? (string) $alerta['signature_id']
                    : null,

                'fecha_evento' => Carbon::parse(
                    $evento['timestamp']
                ),
            ];

            try {
                // Evita volver a insertar el mismo evento
                $existe = AlertaSuricata::where(
                    'flow_id',
                    $datos['flow_id']
                )
                ->where('sid', $datos['sid'])
                ->where('fecha_evento', $datos['fecha_evento'])
                ->where('src_ip', $datos['src_ip'])
                ->where('dest_ip', $datos['dest_ip'])
                ->exists();

                if (!$existe) {
                    AlertaSuricata::create($datos);
                    $guardadas++;
                }

            } catch (Throwable $e) {
                $this->error(
                    'Error al guardar una alerta: ' . $e->getMessage()
                );
            }
        }

        $this->info(
            "Lectura finalizada. Alertas nuevas guardadas: {$guardadas}"
        );

        return self::SUCCESS;
    }
}
