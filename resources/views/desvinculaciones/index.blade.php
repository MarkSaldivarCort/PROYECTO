
@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Desvinculaciones</h2>

    {{-- Mensaje de confirmación --}}
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

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para registrar una baja --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-dark text-white">
            Registrar desvinculación
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('desvinculaciones.store') }}">
                @csrf

                <div class="row">
                  
                    <div class="col-md-6 mb-3">

                      <label class="form-label">Buscar empleado</label>

                      <input
                        type="text"
                        id="buscarEmpleado"
                        class="form-control"
                        placeholder="Escribe el nombre o apellido..."
                        autocomplete="off"
                      >

                      <input
                        type="hidden"
                        name="empleado_id"
                        id="empleado_id"
                        required
                      >

                      <div id="resultadosEmpleados"
                        class="list-group mt-1">
                      </div>

                      <div id="empleadoSeleccionado"
                        class="mt-2 text-success">
                      </div>
                      <div id="antiguedadEmpleado" class="mt-3" style="display: none;">
                        <div class="alert alert-info">
                          <strong>Antigüedad laboral:</strong>
                          <span id="valorAntiguedad"></span>
                        </div>
                      </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">Fecha de baja</label>

                        <input
                          type="date"
                          name="fecha_baja"
                          class="form-control"
                          value="{{ old('fecha_baja') }}"
                          required
                        >

                    </div>

                    <div class="col-md-8 mb-3">

                        <label class="form-label">Motivo de desvinculación</label>

                        <input
                            type="text"
                            name="motivo"
                            class="form-control"
                            maxlength="120"
                            value="{{ old('motivo') }}"
                            placeholder="Ingrese el motivo"
                            required
                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">Finiquito (MXN)</label>

                        <input
                            type="number"
                            name="finiquito"
                            class="form-control"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Observaciones</label>
                      <textarea
                        name="observaciones"
                        class="form-control"
                        rows="2"
                        maxlength="1000"
                        placeholder="Información adicional"
                      >{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Confirma tu contraseña</label>

                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Ingresa tu contraseña actual"
                        autocomplete="current-password"
                        required
                      >

                      <small class="text-muted">
                        Por seguridad, debes confirmar tu contraseña para registrar la desvinculación.
                      </small>
                    </div>

                </div>

                <button type="submit" class="btn btn-danger">
                    Registrar baja
                </button>

            </form>

        </div>

    </div>

    {{-- Historial de desvinculaciones --}}
    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            Historial de desvinculaciones
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Empleado</th>
                            <th>Motivo</th>
                            <th>Finiquito</th>
                            <th>Responsable</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($desvinculaciones as $desvinculacion)

                            <tr>

                                <td>
                                    {{ $desvinculacion->fecha_baja?->format('d/m/Y') }}
                                </td>

                                <td>
                                    @if($desvinculacion->empleado)
                                        {{ $desvinculacion->empleado->nombres }}
                                        {{ $desvinculacion->empleado->apellidos }}
                                    @else
                                        No disponible
                                    @endif
                                </td>

                                <td>{{ $desvinculacion->motivo }}</td>

                                <td>
                                    ${{ number_format((float)$desvinculacion->finiquito, 2) }}
                                </td>

                                <td>
                                    {{ $desvinculacion->responsable
                                        ? $desvinculacion->responsable->nombres . ' ' . $desvinculacion->responsable->apellidos
                                        : 'No disponible' }}
                                </td>

                                <td>
                                    {{ $desvinculacion->observaciones ?: 'Sin observaciones' }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    No hay desvinculaciones registradas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $desvinculaciones->links() }}

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const buscador = document.getElementById('buscarEmpleado');
    const resultados = document.getElementById('resultadosEmpleados');
    const empleadoId = document.getElementById('empleado_id');
    const seleccionado = document.getElementById('empleadoSeleccionado');
    const antiguedadEmpleado = document.getElementById('antiguedadEmpleado');
    const valorAntiguedad = document.getElementById('valorAntiguedad'); 

    let temporizador;

    buscador.addEventListener('input', function () {

        clearTimeout(temporizador);

        empleadoId.value = '';
        seleccionado.textContent = '';
        resultados.innerHTML = '';
        antiguedadEmpleado.style.display = 'none';
        valorAntiguedad.textContent = '';


        const texto = this.value.trim();

        if (texto.length < 2) {
            return;
        }

        temporizador = setTimeout(() => {

            fetch(`{{ route('desvinculaciones.buscarEmpleados') }}?q=${encodeURIComponent(texto)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la búsqueda');
                    }
                    return response.json();
                })
                .then(empleados => {

                    resultados.innerHTML = '';

                    if (empleados.length === 0) {
                        resultados.innerHTML =
                            '<div class="list-group-item">No se encontraron empleados activos.</div>';
                        return;
                    }

                    empleados.forEach(empleado => {

                        const boton = document.createElement('button');

                        boton.type = 'button';
                        boton.className = 'list-group-item list-group-item-action';

                        boton.textContent =
                            `${empleado.nombres} ${empleado.apellidos}`;

                        boton.addEventListener('click', function () {
                          empleadoId.value = empleado.id;
                          buscador.value = `${empleado.nombres} ${empleado.apellidos}`;

                          seleccionado.textContent = 'Empleado seleccionado correctamente.';

                          if (empleado.antiguedad !== null) {
                            valorAntiguedad.textContent = `${empleado.antiguedad} años`;
                            antiguedadEmpleado.style.display = 'block';
                          } else {
                            valorAntiguedad.textContent = 'Sin fecha de ingreso registrada';
                            antiguedadEmpleado.style.display = 'block';
                          }

                          resultados.innerHTML = '';
                        });

                        resultados.appendChild(boton);

                    });

                })
                .catch(error => {
                    console.error(error);
                    resultados.innerHTML =
                        '<div class="list-group-item text-danger">No fue posible realizar la búsqueda.</div>';
                });

        }, 300);

    });

});
</script>


@endsection
