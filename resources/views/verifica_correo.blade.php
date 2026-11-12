<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Verificación de cuenta | RR. HH. - DLP</title>

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

        .verification-body p {
            font-size: .95rem;
            line-height: 1.6;
            color: var(--ipn-gris);
            margin-bottom: 12px;
        }

        .verification-footer {
            text-align: center;
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
                <i class="bi bi-envelope-check"></i>
            </div>

            <h2>Verifica tu cuenta</h2>
        </div>

        <div class="verification-body">

            <p>
                Te hemos enviado un correo electrónico de verificación.
            </p>

            <p>
                Haz clic en el enlace recibido para activar tu cuenta
                y completar tu registro.
            </p>

            <i class="bi bi-shield-check text-secondary fs-3 mt-3"></i>

        </div>

        <div class="verification-footer">
            Sistema de monitoreo y protección de información
        </div>

    </div>

</body>
</html>