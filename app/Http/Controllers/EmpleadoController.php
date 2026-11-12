<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\AuditoriaExportacion;
use App\Models\BloqueoExportacion;

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
        $usuario = auth()->user();

        // Comprobar si el usuario tiene un bloqueo de exportación vigente
        $bloqueo = BloqueoExportacion::where('usuario_id', $usuario->id)
            ->where('bloqueado_hasta', '>', now())
            ->latest('bloqueado_hasta')
            ->first();

        if ($bloqueo) {
            $minutosRestantes = max(
                1,
                (int) ceil(now()->diffInSeconds($bloqueo->bloqueado_hasta) / 60)
            );

            return response()->view(
                'empleados.exportacion_bloqueada',
                compact('minutosRestantes'),
                429
            );
        }
       
        // Contar las exportaciones del usuario durante los últimos 10 minutos
        $exportacionesRecientes = AuditoriaExportacion::where('usuario_id', $usuario->id)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->count();

        // Si ya realizó 3 exportaciones, generar un bloqueo preventivo
        if ($exportacionesRecientes >= 3) {

            BloqueoExportacion::create([
                'usuario_id' => $usuario->id,
                'ip' => request()->ip(),
                'motivo' => 'Bloqueo preventivo por realizar 3 exportaciones en menos de 10 minutos',
                'bloqueado_hasta' => now()->addMinutes(10),
            ]);

            return response()->view(
                'empleados.exportacion_bloqueada',
                ['minutosRestantes' => 10],
                429
            );
        }

        // Registrar quién realizó la exportación
        AuditoriaExportacion::create([
            'usuario_id' => $usuario->id,
            'nombre_usuario' => $usuario->nombres . ' ' . $usuario->apellidos,
            'tipo_usuario' => $usuario->tipo_usuario,
            'ip' => request()->ip(),
            'created_at' => now(),
        ]);


        $empleados = Empleado::all();

        $archivo = 'empleados.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $archivo . '"',
        ];

        $callback = function () use ($empleados) {
            $file = fopen('php://output', 'w');

            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'id', 'nombre', 'rfc', 'curp', 'nss', 'puesto',
                'departamento', 'salario', 'correo', 'teléfono',
                'estatus', 'fecha de ingreso', 'fecha de baja'
            ]);

            foreach ($empleados as $e) {
                fputcsv($file, [
                    $e->id, $e->nombre, $e->rfc, $e->curp, $e->nss,
                    $e->puesto, $e->departamento, $e->salario, $e->email,
                    $e->telefono, $e->estatus, $e->fecha_ingreso, $e->fecha_baja
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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