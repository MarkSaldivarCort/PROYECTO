
@extends('layouts.app')

@section('title', 'Ficha del empleado')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado --}}
    <div class="card border-0 shadow-sm mb-4"
         style="background-color: #6F1D46; color: white;">

        <div class="card-body p-4">

            <div class="d-flex align-items-center">

                <div class="rounded-3 p-3 me-3"
                     style="background-color: rgba(255,255,255,.15);">
                    <i class="bi bi-person-badge fs-2"></i>
                </div>

                <div>
                    <h3 class="fw-bold mb-1">
                        {{ $empleado->nombres }} {{ $empleado->apellidos }}
                    </h3>

                    <p class="mb-0 opacity-75">
                        Ficha individual del empleado
                    </p>
                </div>

            </div>

        </div>
    </div>

    {{-- Identificación --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                <i class="bi bi-person-vcard me-2"
                   style="color: #6F1D46;"></i>
                Información de identificación
            </h5>

            <div class="row g-4">

                <div class="col-md-4">
                    <small class="text-muted d-block">ID de empleado</small>
                    <strong>{{ $empleado->id }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">RFC</small>
                    <strong>{{ $empleado->rfc }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">CURP</small>
                    <strong>{{ $empleado->curp }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">NSS</small>
                    <strong>{{ $empleado->nss }}</strong>
                </div>

            </div>

        </div>
    </div>

    {{-- Información laboral --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                <i class="bi bi-briefcase me-2"
                   style="color: #6F1D46;"></i>
                Información laboral
            </h5>

            <div class="row g-4">

                <div class="col-md-4">
                    <small class="text-muted d-block">Puesto</small>
                    <strong>{{ $empleado->puesto }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Departamento</small>
                    <strong>{{ $empleado->departamento }}</strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">Salario</small>
                    <strong>
                        ${{ number_format((float) $empleado->salario, 2) }}
                    </strong>
                </div>

            </div>

        </div>
    </div>

    {{-- Información de contacto --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                <i class="bi bi-telephone me-2"
                   style="color: #6F1D46;"></i>
                Información de contacto
            </h5>

            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted d-block">Correo electrónico</small>
                    <strong>{{ $empleado->email }}</strong>
                </div>

                <div class="col-md-6">
                    <small class="text-muted d-block">Teléfono</small>
                    <strong>{{ $empleado->telefono }}</strong>
                </div>

            </div>

        </div>
    </div>

    {{-- Regresar --}}
    <div class="d-flex justify-content-end mb-4">

        <a href="{{ route('dashboard') }}"
           class="btn text-white px-4"
           style="background-color: #6F1D46;">

            <i class="bi bi-arrow-left me-2"></i>
            Regresar al directorio

        </a>

    </div>

</div>

@endsection
