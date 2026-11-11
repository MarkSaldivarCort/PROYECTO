@extends('layouts.app')

@section('content')
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Empleados</h5>
                <h2>{{ $empleados->total() }}</h2>
            </div>
        </div>
    </div>

</div>
<div class="container mt-4">

    <h2>Empleados</h2>

    <form method="GET"
          action="{{ route('dashboard') }}"
          class="row mb-3">

        <div class="col-md-8">

            <input
                type="text"
                name="q"
                class="form-control"
                placeholder="Buscar nombre o departamento"
                value="{{ request('q') }}"
            >

        </div>

        <div class="col-md-2">

            <button class="btn btn-primary w-100">
                Buscar
            </button>

        </div>

        <div class="col-md-2">

            <a href="{{ route('empleados.exportar') }}"
               class="btn btn-success w-100">
                Exportar CSV
            </a>

        </div>

    </form>

</div>

<div class="table-responsive">

<table class="table table-dark table-hover">

<thead>

<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>RFC</th>
    <th>CURP</th>
    <th>Puesto</th>
    <th>Departamento</th>
    <th>Estatus</th>
</tr>

</thead>

<tbody>

@foreach($empleados as $empleado)

<tr>

    <td>{{ $empleado->id }}</td>

    <td>
        <a href="{{ route('empleados.show', $empleado->id) }}">
            {{ $empleado->nombres }} {{ $empleado->apellidos }}
        </a>
    </td>

    <td>{{ $empleado->rfc }}</td>

    <td>{{ $empleado->curp }}</td>

    <td>{{ $empleado->puesto }}</td>

    <td>{{ $empleado->departamento }}</td>

    <td>

        @if($empleado->estatus == 'activo')

            <span class="badge bg-success">
                Activo
            </span>

        @else

            <span class="badge bg-warning">
                Desvinculado
            </span>

        @endif

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

{{ $empleados->links() }}

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Salir</button>
</form>


@endsection