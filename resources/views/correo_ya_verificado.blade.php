<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlace de verificación no disponible</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow border-0">

                <div class="card-body text-center p-5">

                    <h2 class="text-primary mb-4">
                        Información sobre el enlace de verificación
                    </h2>

                    <div class="mb-4" style="font-size: 3rem;">
                        ℹ️
                    </div>

                    <p class="lead">
                        Este enlace de verificación ya no está disponible.
                    </p>

                    <hr>

                    <p>
                        El enlace puede haber sido utilizado previamente,
                        haber expirado o ya no ser válido por motivos de
                        seguridad.
                    </p>

                    <p>
                        Si tu dirección de correo electrónico ya fue
                        verificada correctamente, puedes iniciar sesión
                        normalmente en el sistema.
                    </p>

                    <p>
                        Si aún no has verificado tu cuenta, solicita un nuevo
                        correo de verificación o contacta con el
                        administrador del sistema.
                    </p>

                    <div class="mt-4">

                        <a href="{{ url('/login') }}"
                           class="btn btn-primary me-2">
                            Iniciar sesión
                        </a>

                        <a href="{{ url('/registro') }}"
                           class="btn btn-outline-secondary">
                            Registrarse
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>