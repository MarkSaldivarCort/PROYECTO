@extends('layouts.app')

@section('title', 'Desvinculaciones')

@section('content')

<div class="container-fluid px-0">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Gestión de desvinculaciones</h2>

        <p class="text-muted mb-0">
            Registro y seguimiento de bajas del personal.
        </p>
    </div>

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
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header text-white py-3"
            style="background-color: #6F1D46;">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-person-dash me-2"></i>
                Registrar desvinculación
            </h5>
        </div>

        <div class="card-body p-4">

            <form method="POST" action="{{ route('desvinculaciones.store') }}">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Buscar empleado
                        </label>

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

                        <div id="antiguedadEmpleado"
                            class="mt-3"
                            style="display: none;">
                            <div class="alert alert-info mb-0">
                                <strong>Antigüedad laboral:</strong>
                                <span id="valorAntiguedad"></span>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Fecha de baja
                        </label>

                        <input
                            type="date"
                            name="fecha_baja"
                            class="form-control"
                            value="{{ old('fecha_baja') }}"
                            required
                        >

                    </div>

                    <div class="col-md-8 mb-3">

                        <label class="form-label fw-semibold">
                            Motivo de desvinculación
                        </label>

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

                        <label class="form-label fw-semibold">
                            Finiquito (MXN)
                        </label>

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

                        <label class="form-label fw-semibold">
                            Observaciones
                        </label>

                        <textarea
                            name="observaciones"
                            class="form-control"
                            rows="2"
                            maxlength="1000"
                            placeholder="Información adicional"
                        >{{ old('observaciones') }}</textarea>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Confirma tu contraseña
                        </label>

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

                <div class="d-flex justify-content-end pt-3 border-top">

                    <button type="submit"
                            class="btn text-white px-4"
                            style="background-color: #6F1D46;">
                        <i class="bi bi-person-check me-2"></i>
                        Registrar baja
                    </button>

                </div>

            </form>

        </div>
    </div>


    
    {{-- Historial de desvinculaciones --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header text-white py-3"
            style="background-color: #6F1D46;">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-clock-history me-2"></i>
                Historial de desvinculaciones
            </h5>
        </div>

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr style="background-color: #6F1D46; color: white;">
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

                                <td class="text-nowrap">
                                    {{ $desvinculacion->fecha_baja?->format('d/m/Y') }}
                                </td>

                                <td class="fw-semibold">
                                    @if($desvinculacion->empleado)
                                        {{ $desvinculacion->empleado->nombres }}
                                        {{ $desvinculacion->empleado->apellidos }}
                                    @else
                                        <span class="text-muted">No disponible</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $desvinculacion->motivo }}
                                </td>

                                <td class="text-nowrap fw-semibold">
                                    ${{ number_format((float)$desvinculacion->finiquito, 2) }}
                                </td>

                                <td>
                                    {{ $desvinculacion->responsable
                                        ? $desvinculacion->responsable->nombres . ' ' . $desvinculacion->responsable->apellidos
                                        : 'No disponible' }}
                                </td>

                                <td style="min-width: 180px;">
                                    {{ $desvinculacion->observaciones ?: 'Sin observaciones' }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay desvinculaciones registradas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $desvinculaciones->links() }}
            </div>

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
