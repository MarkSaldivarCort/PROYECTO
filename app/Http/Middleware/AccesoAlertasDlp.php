<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccesoAlertasDlp
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $rol = auth()->user()->tipo_usuario;

        if (!in_array($rol, ['admin', 'colaborador'])) {
            abort(403, 'No tienes permisos para consultar las alertas DLP.');
        }

        return $next($request);
    }
}
