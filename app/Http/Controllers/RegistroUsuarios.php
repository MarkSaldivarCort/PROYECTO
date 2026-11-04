<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistroUsuarios extends Controller
{
    public function mostrar(){
        return view("registro");
    }

    public function cargarBD(Request $request){

        $request->validate([
            'nombre' => 'required|max:25',
            'apellidos' => 'required|max:30',      
            'correo_electronico' => 'required|email|unique:usuarios,email|max:50',
            'telefono' => 'required|numeric|digits_between:10,12',
            'nombre_de_usuario' => 'required|max:15|unique:usuarios,nombre_de_usuario',
            'password' => 'required|min:8|confirmed'
        ],
        [
            'telefono.digit_between' => 'Debes introducir un número de teléfono válido.',
            'telefono.numeric' => 'El telefono debe ser numérico.',
            'correo_electronico.unique' => 'Este correo ya está asociado a una cuenta.',
            'correo_electronico.email' => 'El formato del correo es inválido.',
            'nombre_de_usuario.required' => 'Debes introducir un nombre de usuario.',
            'nombre_de_usuario.unique' => 'Nombre de usuario no disponible.',
            'password.required' => 'Debes introducir una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'            
        ]);

        $usuario = usuarios::create([
            'nombres' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->correo_electronico,
            'telefono' => $request->telefono,
            'nombre_de_usuario' => $request->nombre_de_usuario,
            'password' => bcrypt($request->password),
            'verification_token' => Str::uuid()
        ]);
        Auth::login($usuario);
        $usuario->sendEmailVerificationNotification();
        return redirect('/email/verificar');
        //return redirect('/login')->with('success', 'Usuario registrado correctamente');
    }

    public function eliminarUsuario($id)
    {
        $usuario = Usuarios::find($id);

        if ($usuario) {
            $usuario->delete();
        }

        return redirect('/')->with('success', 'Usuario eliminado');
    }
}
