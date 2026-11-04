
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha del empleado</title>
</head>
<body>

    <h1>Ficha del empleado</h1>

    <p><strong>ID:</strong> {{ $empleado->id }}</p>
    <p><strong>Nombre:</strong> {{ $empleado->nombres }} {{ $empleado->apellidos }}</p>
    <p><strong>RFC:</strong> {{ $empleado->rfc }}</p>
    <p><strong>CURP:</strong> {{ $empleado->curp }}</p>
    <p><strong>NSS:</strong> {{ $empleado->nss }}</p>
    <p><strong>Puesto:</strong> {{ $empleado->puesto }}</p>
    <p><strong>Departamento:</strong> {{ $empleado->departamento }}</p>
    <p><strong>Salario:</strong> {{ $empleado->salario }}</p>
    <p><strong>Correo:</strong> {{ $empleado->email }}</p>
    <p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>

    <a href="{{ url('/empleados') }}">Regresar</a>

</body>
</html>
