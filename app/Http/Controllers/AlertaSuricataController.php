<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertaSuricata;

class AlertaSuricataController extends Controller
{
    public function index()
    {
        $alertas = AlertaSuricata::orderBy(
            'fecha_evento',
            'desc'
        )->paginate(20);

        return view('alertas.index', compact('alertas'));
    }
}