<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Enlace de verificación no disponible | RR. HH. - DLP</title>

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

        .information-card {
            width: 100%;
            max-width: 650px;
            background-color: var(--ipn-blanco);
            border: 1px solid var(--ipn-borde);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .information-header {
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            padding: 28px 20px;
        }

        .information-icon {
            font-size: 2.7rem;
            margin-bottom: 10px;
        }

        .information-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }

        .information-body {
            padding: 35px;
        }

        .notice-icon {
            font-size: 3.2rem;
            color: var(--ipn-gris);
            margin-bottom: 15px;
        }

        .information-body .lead {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--ipn-texto);
        }

        .information-body p {
            font-size: .92rem;
            line-height: 1.7;
            color: var(--ipn-gris);
        }

        .information-body hr {
            border-color: var(--ipn-borde);
            opacity: 1;
            margin: 22px 0;
        }

        .btn-login {
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            border: 1px solid var(--ipn-guinda);
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 5px;
        }

        .btn-login:hover {
            background-color: var(--ipn-guinda-oscuro);
            border-color: var(--ipn-guinda-oscuro);
            color: var(--ipn-blanco);
        }

        .btn-register {
            background-color: transparent;
            color: var(--ipn-gris);
            border: 1px solid var(--ipn-gris);
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 5px;
        }

        .btn-register:hover {
            background-color: var(--ipn-gris);
            color: var(--ipn-blanco);
        }

        .information-footer {
            color: var(--ipn-gris);
            font-size: .75rem;
            padding: 15px;
            border-top: 1px solid var(--ipn-borde);
        }

        @media (max-width: 576px) {
            .information-body {
                padding: 25px 20px;
            }

            .information-actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .information-actions .btn {
                width: 100%;
                margin: 0 !important;
            }
        }
    </style>
</head>

<body>

    <div class="information-card">

        <div class="information-header">
            <div class="information-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <h2>Información sobre el enlace de verificación</h2>
        </div>

        <div class="information-body">

            <div class="notice-icon">
                <i class="bi bi-info-circle"></i>
            </div>

            <h4 class="fw-semibold mb-3">
                Este enlace de verificación ya no está disponible
            </h4>

            <p>
                El enlace puede haber sido utilizado previamente,
                haber expirado o ya no ser válido por motivos de seguridad.
            </p>

            <hr>

            <p>
                Si tu dirección de correo electrónico ya fue verificada
                correctamente, puedes iniciar sesión normalmente en el sistema.
            </p>

            <p>
                Si aún no has verificado tu cuenta, solicita un nuevo correo
                de verificación o contacta con el administrador del sistema.
            </p>

            <div class="information-actions mt-4">

                <a href="{{ url('/login') }}" class="btn btn-login me-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Iniciar sesión
                </a>

                <a href="{{ url('/registro') }}" class="btn btn-register">
                    <i class="bi bi-person-plus me-1"></i>
                    Registrarse
                </a>

            </div>

        </div>

        <div class="information-footer">
            Sistema de monitoreo y protección de información
        </div>

    </div>

</body>
</html>