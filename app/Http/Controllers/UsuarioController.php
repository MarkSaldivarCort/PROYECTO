<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuarios::orderBy('id', 'asc')
            ->paginate(20);

        return view('usuarios.index', compact('usuarios'));
    }

    public function actualizarRol(Request $request, Usuarios $usuario)
    {
        $datos = $request->validate([
            'tipo_usuario' => 'required|in:admin,colaborador,analista_rrhh',
            'password' => 'required|string',
        ]);

        // Verificar la contraseña del administrador autenticado
        if (!Hash::check($datos['password'], auth()->user()->password)) {
            return back()
                ->withErrors([
                    'password' => 'La contraseña ingresada es incorrecta.'
                ])
                ->withInput($request->except('password'));
        }

        // Evitar que el sistema se quede sin administradores
        $actualizado = DB::transaction(function () use ($usuario, $datos) {

            $usuarios = Usuarios::orderBy('id')
                ->lockForUpdate()
                ->get();

            $objetivo = $usuarios->firstWhere('id', $usuario->id);

            $totalAdministradores = $usuarios
                ->where('tipo_usuario', 'admin')
                ->count();

            if (
                $objetivo->tipo_usuario === 'admin' &&
                $datos['tipo_usuario'] !== 'admin' &&
                $totalAdministradores <= 1
            ) {
                return false;
            }

            $objetivo->update([
                'tipo_usuario' => $datos['tipo_usuario']
            ]);

            return true;
        });

        if (!$actualizado) {
            return back()->with(
                'error',
                'No puedes quitar el rol al último administrador del sistema.'
            );
        }

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'El rol del usuario se actualizó correctamente.');
    }
}
