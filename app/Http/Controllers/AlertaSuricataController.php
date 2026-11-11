<?php

namespace App\Http\Controllers;

use App\Models\AlertaSuricata;

class AlertaSuricataController extends Controller
{
    public function index()
    {
        $alertas = AlertaSuricata::orderBy(
            'fecha_evento',
            'desc'
        )->paginate(10);

        $exportaciones = AlertaSuricata::where(
            'sid',
            1000001
        )->count();

        $totalAlertas = $alertas->count();

        $criticas = $alertas
            ->where('severity', 1)
            ->count();
        $altas = $alertas
            ->where('severity', 2)
            ->count();
        
        return view(
            'alertas_suricata',
            compact(
                'alertas',
                'totalAlertas',
                'criticas',
                'altas',
                'exportaciones'
            )
        );
    }

     public function show($id)
    {
        $alerta = AlertaSuricata::findOrFail($id);

        return view('alertas.show', compact('alerta'));
    }
}