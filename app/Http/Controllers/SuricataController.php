<?php
namespace App\Http\Controllers;

use App\Models\AlertaSuricata;
use phpseclib4\Net\SSH2;
use Carbon\Carbon;

class SuricataController extends Controller
{
    public function importarAlertas()
    {
        $ssh = new SSH2('192.168.100.29');

        if (!$ssh->login('USUARIO_ELIMINADO', 'CREDENCIAL_ELIMINADA')) {
            return response()->json([
                'error' => 'No se pudo conectar a Suricata'
            ], 500);
        }

        $contenido = $ssh->exec(
            'tail -n 500 /var/log/suricata/eve.json'
        );

        $lineas = explode("\n", trim($contenido));

        $eventosLeidos = 0;
        $alertasGuardadas = 0;
        $descartadasPorSid = 0;
        $descartadasPorFirma = 0;
        $duplicadas = 0;

        /*
        SID de tus reglas personalizadas DLP
        */
        $sidsPermitidos = [

            1000001,
            1000002,
            1000003,
            1000004,
        ];

        /*
        Nombre exacto de tus reglas DLP
        */
        $firmasPermitidas = [

            'RRHH-DLP Exportacion masiva de empleados',
            'RRHH-DLP Exportacion de multiples RFC sin enmascarar',
            'RRHH-DLP Consulta masiva de fichas de empleados',
            'RRHH-DLP Posible SQL Injection',

        ];

        $importadas = 0;

        foreach ($lineas as $linea) {
            $eventosLeidos++;
            if (empty($linea)) {
                continue;
            }

            $evento = json_decode($linea, true);
            $fechaEvento = Carbon::parse(
                $evento['timestamp']
            )->format('Y-m-d H:i:s');
            
            if (!$evento) {
                continue;
            }

            /*
            Solo eventos tipo alert
            */
            if (
                !isset($evento['event_type']) ||
                $evento['event_type'] !== 'alert'
            ) {
                continue;
            }

            if (!isset($evento['alert'])) {
                continue;
            }

            $sid = $evento['alert']['signature_id'] ?? null;

            $firma = $evento['alert']['signature'] ?? '';

            /*
            Validación por SID
            */
            if (!in_array($sid, $sidsPermitidos)) {
                $descartadasPorSid++;
                continue;
            }

            /*
            Validación por firma
            */
            if (!in_array($firma, $firmasPermitidas)) {
                $descartadasPorFirma++;
                continue;
            }

            /*
            Evitar duplicados
            */
            $existe = AlertaSuricata::where(
                'flow_id',
                $evento['flow_id']
            )
            ->where(
                'sid',
                $sid
            )
            ->exists();

            if ($existe) {
                $duplicadas++;
                continue;
            }

            AlertaSuricata::create([
                
                'flow_id' => $evento['flow_id'] ?? null,

                'src_ip' => $evento['src_ip'] ?? null,

                'dest_ip' => $evento['dest_ip'] ?? null,

                'signature' => $firma,

                'severity' =>
                    $evento['alert']['severity'] ?? null,

                'sid' => $sid,

                'fecha_evento' =>
                    $fechaEvento,

                'event_type' =>
                    $evento['event_type'] ?? null,

                'http_method' =>
                    $evento['http']['http_method'] ?? null,

                'http_url' =>
                    $evento['http']['url'] ?? null,

                'http_status' =>
                    $evento['http']['status'] ?? null

            ]);
            $alertasGuardadas++;
            $importadas++;
        }

        return response()->json([
            'eventos_leidos' => $eventosLeidos,
            'alertas_guardadas' => $alertasGuardadas,
            'descartadas_por_sid' => $descartadasPorSid,
            'descartadas_por_firma' => $descartadasPorFirma,
            'duplicadas' => $duplicadas
        ]);
    }
}