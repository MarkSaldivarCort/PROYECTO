<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Correo verificado | RR. HH. - DLP</title>

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

        .verification-card {
            width: 100%;
            max-width: 480px;
            background-color: var(--ipn-blanco);
            border: 1px solid var(--ipn-borde);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .verification-header {
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            padding: 28px 20px;
        }

        .verification-icon {
            font-size: 2.8rem;
            margin-bottom: 10px;
        }

        .verification-header h2 {
            font-size: 1.35rem;
            font-weight: 600;
            margin: 0;
        }

        .verification-body {
            padding: 35px 30px;
        }

        .success-icon {
            color: #198754;
            font-size: 3.5rem;
            margin-bottom: 18px;
        }

        .verification-body p {
            font-size: .95rem;
            line-height: 1.6;
            color: var(--ipn-gris);
            margin-bottom: 12px;
        }

        .btn-login {
            background-color: var(--ipn-guinda);
            color: var(--ipn-blanco);
            border: none;
            padding: 11px 22px;
            font-weight: 600;
            border-radius: 5px;
            margin-top: 15px;
        }

        .btn-login:hover {
            background-color: var(--ipn-guinda-oscuro);
            color: var(--ipn-blanco);
        }

        .verification-footer {
            color: var(--ipn-gris);
            font-size: .75rem;
            padding: 15px;
            border-top: 1px solid var(--ipn-borde);
        }
    </style>
</head>

<body>

    <div class="verification-card">

        <div class="verification-header">
            <div class="verification-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <h2>Verificación de cuenta</h2>
        </div>

        <div class="verification-body">

            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <h4 class="fw-semibold mb-3">
                Correo verificado correctamente
            </h4>

            <p>
                Tu cuenta ha sido activada correctamente.
            </p>

            <p>
                Ya puedes acceder al sistema utilizando tus credenciales.
            </p>

            <a href="{{ url('/login') }}" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Ir al inicio de sesión
            </a>

        </div>

        <div class="verification-footer">
            Sistema de monitoreo y protección de información
        </div>

    </div>

</body>
</html>