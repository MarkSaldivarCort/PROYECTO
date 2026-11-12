
@extends('layouts.app')

@section('title', 'Empleados')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Gestión de empleados</h2>
            <p class="text-muted mb-0">
                Consulta y administra la información del personal.
            </p>
        </div>
    </div>

    {{-- Estadística --}}
    <div class="row mb-4">
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3"
                         style="background-color: #F3E8EE; color: #6F1D46;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>

                    <div>
                        <p class="text-muted mb-1">Total de empleados</p>
                        <h3 class="fw-bold mb-0">
                            {{ $empleados->total() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Búsqueda y exportación --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Directorio de empleados</h5>
                <span class="text-muted small">
                    {{ $empleados->total() }} registros encontrados
                </span>
            </div>

            <form method="GET"
                  action="{{ route('empleados.buscar') }}"
                  class="row g-2">

                <div class="col-md-8 position-relative">

                    <input
                        type="text"
                        id="busquedaEmpleados"
                        name="busqueda"
                        class="form-control"
                        placeholder="Buscar por nombre o departamento..."
                        value="{{ request('busqueda') }}"
                        autocomplete="off"
                    >

                    <div
                        id="listaSugerencias"
                        class="list-group position-absolute w-100 shadow"
                        style="z-index: 1050; display: none; top: 100%; left: 0;"
                    >
                    </div>

                </div>

                <div class="col-md-2">
                    <button type="submit"
                            class="btn w-100 text-white"
                            style="background-color: #6F1D46;">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('empleados.exportar') }}"
                       class="btn btn-outline-secondary w-100">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>
                        Exportar CSV
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead style="background-color: #6F1D46; color: white;">
                        <tr>
                            <th class="px-3 py-3">ID</th>
                            <th class="py-3">Nombre</th>
                            <th class="py-3">RFC</th>
                            <th class="py-3">CURP</th>
                            <th class="py-3">Puesto</th>
                            <th class="py-3">Departamento</th>
                            <th class="py-3">Estatus</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($empleados as $empleado)

                            <tr>
                                <td class="px-3">{{ $empleado->id }}</td>

                                <td class="fw-semibold">
                                    {{ $empleado->nombres }}
                                    {{ $empleado->apellidos }}
                                </td>

                                <td>{{ $empleado->rfc }}</td>

                                <td>{{ $empleado->curp }}</td>

                                <td>{{ $empleado->puesto }}</td>

                                <td>{{ $empleado->departamento }}</td>

                                <td>
                                    @if($empleado->estatus == 'activo')
                                        <span class="badge rounded-pill bg-success-subtle text-success">
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('empleados.show', $empleado->id) }}"
                                       class="btn btn-sm text-white"
                                       style="background-color: #6F1D46;">
                                        <i class="bi bi-eye me-1"></i>
                                        Ver información
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No se encontraron empleados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-end mt-4">
        {{ $empleados->links() }}
    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('busquedaEmpleados');
    const lista = document.getElementById('listaSugerencias');

    let temporizador;
    let solicitudActual;

    input.addEventListener('input', function () {

        clearTimeout(temporizador);

        if (solicitudActual) {
            solicitudActual.abort();
        }

        const busqueda = input.value.trim();

        if (busqueda.length < 2) {
            lista.innerHTML = '';
            lista.style.display = 'none';
            return;
        }

        temporizador = setTimeout(async function () {

            solicitudActual = new AbortController();

            try {
                const url = @json(route('empleados.sugerencias'))
                    + '?busqueda=' + encodeURIComponent(busqueda);

                const respuesta = await fetch(url, {
                    signal: solicitudActual.signal,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!respuesta.ok) {
                    throw new Error('Error al consultar sugerencias');
                }

                const empleados = await respuesta.json();

                // Evitar mostrar resultados de una búsqueda anterior.
                if (input.value.trim() !== busqueda) {
                    return;
                }

                lista.innerHTML = '';

                if (empleados.length === 0) {
                    lista.style.display = 'none';
                    return;
                }

                empleados.forEach(function (empleado) {

                    const opcion = document.createElement('button');

                    opcion.type = 'button';
                    opcion.className = 'list-group-item list-group-item-action';

                    const nombre = document.createElement('strong');
                    nombre.textContent =
                        empleado.nombres + ' ' + empleado.apellidos;

                    const departamento = document.createElement('small');
                    departamento.className = 'd-block text-muted';
                    departamento.textContent =
                        empleado.departamento || 'Sin departamento';

                    opcion.appendChild(nombre);
                    opcion.appendChild(departamento);

                    opcion.addEventListener('click', function () {
                        input.value =
                            empleado.nombres + ' ' + empleado.apellidos;

                        lista.innerHTML = '';
                        lista.style.display = 'none';
                        input.closest('form').submit();
                    });

                    lista.appendChild(opcion);
                });

                lista.style.display = 'block';

            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error(error);
                    lista.style.display = 'none';
                }
            }

        }, 300);
    });

    // Ocultar sugerencias al hacer clic fuera del buscador.
    document.addEventListener('click', function (event) {
        if (!input.contains(event.target) &&
            !lista.contains(event.target)) {
            lista.style.display = 'none';
        }
    });

});
</script>


@endsection
