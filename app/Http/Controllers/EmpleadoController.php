<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Empleado::where('estatus', 'activo');

        if ($request->filled('q')) {

            $buscar = $request->q;

            $query->where('nombre','like',"%{$buscar}%")
                  ->orWhere('departamento','like',"%{$buscar}%");
        }

        $empleados = $query->paginate(15);

        return view(
            'dashboard',
            compact('empleados')
        );
    }

    public function exportar()
    {
        $empleados = Empleado::all();

        $archivo = 'empleados.csv';

        $headers = [
        'Content-Type' => 'text/csv',
        ];

        $callback = function() use ($empleados)
        {
            $file = fopen('php://output','w');

            fputcsv($file,[
                'id',
                'nombre',
                'rfc',
                'curp',
                'nss',
                'puesto',
                'departamento',
                'salario',
                'correo',
                'teléfono',
                'estatus',
                'fecha de ingreso',
                'fecha de baja'
            ]);

            foreach ($empleados as $e)
            {
                fputcsv($file,[
                    $e->id,
                    $e->nombre,
                    $e->rfc,
                    $e->curp,
                    $e->nss,
                    $e->puesto,
                    $e->departamento,
                    $e->salario,
                    $e->email,
                    $e->telefono,
                    $e->estatus,
                    $e->fecha_ingreso,
                    $e->fecha_baja
                ]);
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }

    public function buscar(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $empleados = Empleado::where('estatus', 'activo')
            ->where(function ($query) use ($busqueda) {
                $query->where('nombres', 'like', "%{$busqueda}%")
                    ->orWhere('apellidos', 'like', "%{$busqueda}%")
                    ->orWhere('departamento', 'like', "%{$busqueda}%");
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard', compact('empleados'));
    }

    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);

        return view(
            'empleados.show',
            compact('empleado')
        );
    }
}