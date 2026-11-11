@extends('layouts.app')

@section('content')

<h1>Ficha del empleado</h1>

<p><strong>ID:</strong> {{ $empleado->id }}</p>

<p>
    <strong>Nombre:</strong>
    {{ $empleado->nombres }} {{ $empleado->apellidos }}
</p>

<p><strong>RFC:</strong> {{ $empleado->rfc }}</p>
<p><strong>CURP:</strong> {{ $empleado->curp }}</p>
<p><strong>NSS:</strong> {{ $empleado->nss }}</p>
<p><strong>Puesto:</strong> {{ $empleado->puesto }}</p>
<p><strong>Departamento:</strong> {{ $empleado->departamento }}</p>
<p><strong>Salario:</strong> {{ $empleado->salario }}</p>
<p><strong>Correo:</strong> {{ $empleado->email }}</p>
<p><strong>Teléfono:</strong> {{ $empleado->telefono }}</p>

<div class="mt-4">

    <a href="{{ route('dashboard') }}"
       class="btn btn-primary">
        ← Regresar
    </a>

</div>

@endsection