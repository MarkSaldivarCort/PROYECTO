<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloAdministrador
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->tipo_usuario !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}