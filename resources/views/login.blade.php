<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inicio de sesión | RR. HH. - DLP</title>

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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--ipn-fondo);
            color: var(--ipn-texto);
            font-family: "Segoe UI", Arial, sans-serif;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background-color: var(--ipn-blanco);
            border: 1px solid var(--ipn-borde);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .login-header {
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            text-align: center;
            padding: 30px 25px;
        }

        .login-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .login-header h2 {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: .8rem;
            opacity: .85;
            margin: 0;
            letter-spacing: .5px;
        }

        .login-body {
            padding: 30px;
        }

        .form-label {
            font-size: .9rem;
            font-weight: 600;
        }

        .form-control {
            padding: 11px 12px;
            border-color: var(--ipn-borde);
            font-size: .9rem;
        }

        .form-control:focus {
            border-color: var(--ipn-guinda);
            box-shadow: 0 0 0 .2rem rgba(111, 29, 70, .12);
        }

        .btn-login {
            width: 100%;
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            border: none;
            padding: 11px;
            font-weight: 600;
            border-radius: 5px;
        }

        .btn-login:hover {
            background-color: var(--ipn-guinda-oscuro);
            color: var(--ipn-blanco);
        }

        .login-footer {
            text-align: center;
            color: var(--ipn-gris);
            font-size: .75rem;
            padding: 15px;
            border-top: 1px solid var(--ipn-borde);
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-header">
            <div class="login-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <h2>Acceso de usuarios</h2>
            <p>GESTIÓN Y PROTECCIÓN DE DATOS</p>
        </div>

        <div class="login-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-3">
                    <label for="nombre_de_usuario" class="form-label">
                        Nombre de usuario
                    </label>

                    <input
                        type="text"
                        id="nombre_de_usuario"
                        name="nombre_de_usuario"
                        class="form-control"
                        placeholder="Ingresa tu nombre de usuario"
                        value="{{ old('nombre_de_usuario') }}"
                        autocomplete="username"
                        required
                        autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Ingresa tu contraseña"
                        autocomplete="current-password"
                        required>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Iniciar sesión
                </button>

            </form>
        </div>

        <div class="login-footer">
            Sistema de monitoreo y protección de información
        </div>

    </div>

</body>
</html>