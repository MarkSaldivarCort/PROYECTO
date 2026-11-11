<?php

namespace App\Http\Controllers;

use App\Models\Desvinculacion;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DesvinculacionController extends Controller
{
    public function index()
    {
        $activos = Empleado::where('estatus', 'activo')
            ->orderBy('nombres')
            ->get();

        $desvinculaciones = Desvinculacion::with([
            'empleado',
            'responsable'
        ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('desvinculaciones.index', compact(
            'activos',
            'desvinculaciones'
        ));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'motivo' => 'required|string|max:120',
            'fecha_baja' => 'required|date',
            'finiquito' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:1000',
            'password' => 'required|string',
        ]);

        $responsableId = Auth::id();

        if (!Hash::check($datos['password'], Auth::user()->password)) {
            return back()
                ->withInput($request->except('password'))
                ->with('error', 'La contraseña ingresada es incorrecta. No se realizó la desvinculación.');
        }

        if (!$responsableId) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        DB::transaction(function () use ($datos, $responsableId) {

            $empleado = Empleado::where('estatus', 'activo')
                ->lockForUpdate()
                ->findOrFail($datos['empleado_id']);

            Desvinculacion::create([
                'empleado_id' => $empleado->id,
                'responsable_id' => $responsableId,
                'fecha_baja' => $datos['fecha_baja'],
                'motivo' => $datos['motivo'],
                'finiquito' => $datos['finiquito'],
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            $empleado->update([
                'estatus' => 'inactivo',
                'fecha_baja' => $datos['fecha_baja'],
            ]);
        });

        return redirect()
            ->route('desvinculaciones.index')
            ->with('success', 'Desvinculación registrada correctamente.');
    }


    public function buscarEmpleados(Request $request)
    {
        $busqueda = $request->input('q');

        $empleados = Empleado::where('estatus', 'activo')
            ->where(function ($query) use ($busqueda) {
                $query->where('nombres', 'like', "%{$busqueda}%")
                    ->orWhere('apellidos', 'like', "%{$busqueda}%");
            })
            ->limit(10)
            ->get(['id', 'nombres', 'apellidos', 'fecha_ingreso']);

            $empleados->each(function ($empleado) {
            $empleado->append('antiguedad');
        });

        return response()->json($empleados);
    }

}
