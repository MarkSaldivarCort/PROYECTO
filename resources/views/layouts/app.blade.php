
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Panel de gestión') | RR.HH.</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ipn-guinda: #6F1D46;
            --ipn-guinda-oscuro: #531333;
            --ipn-gris: #636569;
            --ipn-fondo: #F4F4F5;
            --ipn-blanco: #FFFFFF;
            --ipn-texto: #292929;
            --ipn-borde: #E1E1E3;
        }

        body {
            background-color: var(--ipn-fondo);
            color: var(--ipn-texto);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* Barra de navegación */
        .main-navbar {
            background-color: var(--ipn-guinda);
            padding: 12px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ipn-blanco);
            font-weight: 600;
            font-size: 1.05rem;
        }

        .navbar-brand:hover {
            color: var(--ipn-blanco);
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 8px;
            font-size: 1.35rem;
        }

        .brand-subtitle {
            display: block;
            font-size: .62rem;
            letter-spacing: 1px;
            font-weight: 400;
            opacity: .8;
        }

        .main-navbar .nav-link {
            color: rgba(255,255,255,.82);
            padding: 10px 12px;
            border-radius: 5px;
            font-size: .9rem;
            transition: background-color .2s;
        }

        .main-navbar .nav-link:hover,
        .main-navbar .nav-link.active {
            color: var(--ipn-blanco);
            background-color: rgba(255,255,255,.15);
        }

        .main-navbar .nav-link i {
            margin-right: 5px;
        }

        /* Información del usuario */
        .user-info {
            color: var(--ipn-blanco);
            padding: 5px 12px;
            border-left: 1px solid rgba(255,255,255,.3);
        }

        .user-name {
            font-size: .85rem;
            font-weight: 600;
        }

        .user-role {
            font-size: .75rem;
            opacity: .8;
            margin-left: 23px;
        }

        /* Botón de cerrar sesión */
        .logout-button {
            background-color: transparent;
            border: 1px solid rgba(255,255,255,.65);
            color: var(--ipn-blanco);
            padding: 8px 13px;
            border-radius: 5px;
            font-size: .85rem;
            transition: all .2s;
        }

        .logout-button:hover {
            background-color: var(--ipn-blanco);
            color: var(--ipn-guinda);
        }

        /* Contenido */
        .page-container {
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
            padding: 28px 24px;
        }

        @media (max-width: 991px) {
            .user-info {
                border-left: none;
                padding: 12px 0;
            }

            .page-container {
                padding: 20px 15px;
            }

            .logout-button {
                margin-top: 8px;
            }
        }
    </style>
</head>

<body>

@php
    $usuarioActual = Auth::user();

    $tipoUsuario = $usuarioActual?->tipo_usuario;

    $nombreRol = match ($tipoUsuario) {
        'admin' => 'Administrador',
        'analista_rrhh', 'Analista de RRHH' => 'Analista de RR. HH.',
        'colaborador' => 'Colaborador',
        default => $tipoUsuario,
    };
@endphp

<nav class="navbar navbar-expand-lg navbar-dark main-navbar">
    <div class="container-fluid px-lg-4">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <span class="brand-icon">
                <i class="bi bi-shield-lock"></i>
            </span>

            <span>
                RR. HH. | DLP
                <span class="brand-subtitle">GESTIÓN Y PROTECCIÓN DE DATOS</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavigation"
                aria-controls="mainNavigation"
                aria-expanded="false"
                aria-label="Mostrar navegación">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavigation">

            <ul class="navbar-nav ms-lg-4 me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('alertas*') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-people"></i>
                        Empleados
                    </a>
                </li>

                @if($tipoUsuario === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"
                           href="{{ route('usuarios.index') }}">
                            <i class="bi bi-person-gear"></i>
                            Usuarios
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('desvinculaciones.*') ? 'active' : '' }}"
                       href="{{ route('desvinculaciones.index') }}">
                        <i class="bi bi-person-dash"></i>
                        Desvinculaciones
                    </a>
                </li>

                @if(in_array($tipoUsuario, ['admin', 'colaborador']))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alertas') ? 'active' : '' }}"
                           href="{{ route('alertas') }}">
                            <i class="bi bi-shield-exclamation"></i>
                            Alertas DLP
                        </a>
                    </li>
                @endif

            </ul>

            <div class="d-lg-flex align-items-center">

                @if($usuarioActual)
                    <div class="user-info me-lg-3">
                        <div class="user-name">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ $usuarioActual->nombres }} {{ $usuarioActual->apellidos }}
                        </div>

                        <div class="user-role">
                            {{ $nombreRol }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="logout-button">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>

<div class="page-container">
    <main>
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
