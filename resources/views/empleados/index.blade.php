
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
</head>
<body>

    <h1>Registro de empleados</h1>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Puesto</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->id }}</td>
                    <td>
                        {{ $empleado->nombres }}
                        {{ $empleado->apellidos }}
                    </td>
                    <td>{{ $empleado->departamento }}</td>
                    <td>{{ $empleado->puesto }}</td>
                    <td>
                        <a href="{{ url('/empleado.php?id=' . $empleado->id) }}">
                            Consultar ficha
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $empleados->links() }}

</body>
</html>
