<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Mostrar todos los empleados
    public function index()
    {
        $empleados = Empleado::orderBy('id')->paginate(10);

        return view('empleados.index', compact('empleados'));
    }

    // Consultar el perfil de un empleado
    public function show(Request $request)
    {
        $id = $request->query('id');

        $empleado = Empleado::findOrFail($id);

        return view('empleados.show', compact('empleado'));
    }
}