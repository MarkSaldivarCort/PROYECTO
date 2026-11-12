<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registro de usuarios | RR. HH. - DLP</title>

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
            padding: 25px 15px;
        }

        .register-card {
            width: 100%;
            max-width: 650px;
            background-color: var(--ipn-blanco);
            border: 1px solid var(--ipn-borde);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .register-header {
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            text-align: center;
            padding: 25px;
        }

        .register-icon {
            font-size: 2.2rem;
            margin-bottom: 8px;
        }

        .register-header h1 {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .register-header p {
            font-size: .8rem;
            opacity: .85;
            margin: 0;
            letter-spacing: .5px;
        }

        .register-body {
            padding: 30px;
        }

        .form-label {
            font-size: .9rem;
            font-weight: 600;
        }

        .form-control {
            padding: 10px 12px;
            border-color: var(--ipn-borde);
            font-size: .9rem;
        }

        .form-control:focus {
            border-color: var(--ipn-guinda);
            box-shadow: 0 0 0 .2rem rgba(111, 29, 70, .12);
        }

        .field-error {
            display: block;
            color: #B02A37;
            font-size: .8rem;
            margin-top: 5px;
        }

        .btn-register {
            width: 100%;
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            border: none;
            padding: 11px;
            font-weight: 600;
            border-radius: 5px;
        }

        .btn-register:hover {
            background-color: var(--ipn-guinda-oscuro);
            color: var(--ipn-blanco);
        }

        .register-footer {
            text-align: center;
            color: var(--ipn-gris);
            font-size: .75rem;
            padding: 15px;
            border-top: 1px solid var(--ipn-borde);
        }

        @media (max-width: 576px) {
            .register-body {
                padding: 22px 18px;
            }
        }
    </style>
</head>

<body>

    <div class="register-card">

        <div class="register-header">
            <div class="register-icon">
                <i class="bi bi-person-plus"></i>
            </div>

            <h1>Registro de usuario</h1>
            <p>GESTIÓN Y PROTECCIÓN DE DATOS</p>
        </div>

        <div class="register-body">

            <form method="POST" action="{{ url('/registro') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre(s)</label>

                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            class="form-control"
                            maxlength="25"
                            value="{{ old('nombre') }}"
                            required>

                        @error('nombre')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>

                        <input
                            type="text"
                            id="apellidos"
                            name="apellidos"
                            class="form-control"
                            maxlength="30"
                            value="{{ old('apellidos') }}"
                            required>

                        @error('apellidos')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>

                        <input
                            type="email"
                            id="correo"
                            name="correo_electronico"
                            class="form-control"
                            maxlength="50"
                            value="{{ $errors->has('correo_electronico') ? '' : old('correo_electronico') }}"
                            required>

                        @error('correo_electronico')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tel" class="form-label">Teléfono</label>

                        <input
                            type="text"
                            id="tel"
                            name="telefono"
                            class="form-control"
                            maxlength="12"
                            value="{{ $errors->has('telefono') ? '' : old('telefono') }}"
                            required>

                        @error('telefono')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nom_usuario" class="form-label">Nombre de usuario</label>

                        <input
                            type="text"
                            id="nom_usuario"
                            name="nombre_de_usuario"
                            class="form-control"
                            maxlength="15"
                            value="{{ $errors->has('nombre_de_usuario') ? '' : old('nombre_de_usuario') }}"
                            required>

                        @error('nombre_de_usuario')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Contraseña</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            autocomplete="new-password"
                            required>

                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="passw_confirmacion" class="form-label">
                            Confirmar contraseña
                        </label>

                        <input
                            type="password"
                            id="passw_confirmacion"
                            name="password_confirmation"
                            class="form-control"
                            minlength="8"
                            autocomplete="new-password"
                            required>
                    </div>

                </div>

                <button type="submit" class="btn btn-register">
                    <i class="bi bi-person-check me-2"></i>
                    Registrarse
                </button>

            </form>

        </div>

        <div class="register-footer">
            Sistema de monitoreo y protección de información
        </div>

    </div>

</body>
</html>