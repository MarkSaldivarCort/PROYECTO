<?php

namespace App\Http\Controllers;

use phpseclib4\Net\SSH2;

class SuricataController extends Controller
{
    public function eventos()
    {
        $ssh = new SSH2('192.168.100.28');

        if (! $ssh->login('USUARIO_ELIMINADO', 'CREDENCIAL_ELIMINADA')) {
            return 'No se pudo conectar a Suricata';
        }

        $resultado = $ssh->exec(
            'tail -n 20 /var/log/suricata/eve.json'
        );

        $lineas = explode("\n", trim($resultado));

        $eventos = [];

        foreach($lineas as $linea){

            $evento = json_decode($linea,true);

            if(
                isset($evento['event_type']) &&
                $evento['event_type'] == 'alert'
            ){
                $eventos[] = $evento;
            }
        }

        return view(
            'Tabla_prueba',
            compact('eventos')
        );
    }
}