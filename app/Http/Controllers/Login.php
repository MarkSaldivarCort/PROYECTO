<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Login extends Controller

{
    public function mostrar(){
        return view('login');
    }

    public function ingresar(Request $request){
        $usuario = DB::table('usuarios')
        ->where('nombre_de_usuario', $request->nombre_de_usuario)
        ->first();
        if(!$usuario){
            return back()->with('error', 'Usuario no registrado')->withInput();;
        }
        if (!Hash::check($request->password, $usuario->password))
        {
            return back()->with('error', 'Contraseña incorrecta')->withInput();
        }

        return redirect()->route('alertas.index');

    }
}

