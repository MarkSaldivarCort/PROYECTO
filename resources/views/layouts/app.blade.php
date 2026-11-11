<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RR.HH. - Lab DLP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            RR.HH. - Lab DLP
        </a>
        @if(Auth::check())
            <span class="text-white me-3">
                {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}
                |
                {{ Auth::user()->tipo_usuario === 'analista_rrhh'
                    || Auth::user()->tipo_usuario === 'Analista de RRHH'
                    ? 'Analista de RRHH'
                    : (Auth::user()->tipo_usuario === 'admin'
                        ? 'Administrador'
                        : Auth::user()->tipo_usuario) }}
            </span>
        @endif

        <div class="ms-auto">

            <a class="nav-link d-inline text-white" href="{{ route('dashboard') }}">
                Empleados   |
            </a>

            @if(Auth::check() && Auth::user()->tipo_usuario === 'admin')
                <a class="nav-link d-inline text-white" href="{{ route('usuarios.index') }}">
                    Gestión de usuarios |
                </a>
            @endif

            <a class="nav-link d-inline text-white" href="{{ route('desvinculaciones.index') }}">
                Desvinculaciones    |
            </a>

            @if(Auth::check() && Auth::user()->tipo_usuario === 'admin')
                <a class="nav-link d-inline text-white" href="{{ route('alertas') }}">
                    Alertas DLP |
                </a>
            @endif

            <form method="POST"
                  action="{{ route('logout') }}"
                  class="d-inline">

                @csrf

                <button class="btn btn-link text-white">
                    Salir
                </button>

            </form>

        </div>
    </div>
</nav>
<div class="container mt-4">
    <main>
        @yield('content')
    </main>
</div>

</body>

</html>