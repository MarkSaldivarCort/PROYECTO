@extends('layouts.app')

@section('title', 'Exportación bloqueada')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">

            <div class="card border-0 shadow-sm">

                {{-- Encabezado --}}
                <div class="p-4 text-white"
                     style="background-color: #6F1D46; border-radius: 8px 8px 0 0;">

                    <div class="d-flex align-items-center gap-3">

                        <div class="d-flex align-items-center justify-content-center"
                             style="width: 55px; height: 55px; border: 1px solid rgba(255,255,255,.4); border-radius: 8px;">

                            <i class="bi bi-shield-lock-fill fs-2"></i>

                        </div>

                        <div>
                            <h2 class="fw-bold mb-1">Exportación bloqueada</h2>
                            <p class="mb-0 small opacity-75">
                                Protección de información | Sistema DLP
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Contenido --}}
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <i class="bi bi-exclamation-triangle-fill"
                           style="font-size: 3.5rem; color: #B02A37;"></i>

                        <h4 class="fw-bold mt-3">
                            Operación bloqueada por DLP
                        </h4>

                        <p class="text-muted mb-0">
                            La solicitud no cumple con las políticas de seguridad
                            establecidas por el sistema.
                        </p>

                    </div>

                    <div class="p-3 mb-4"
                         style="background-color: #F8F8F9; border: 1px solid #E1E1E3; border-radius: 7px;">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="fw-semibold">
                                Nivel de riesgo
                            </span>

                            <span class="badge bg-danger px-3 py-2">
                                ALTO
                            </span>

                        </div>

                        <hr>

                        <div class="mb-3">
                            <span class="fw-semibold d-block mb-1">
                                <i class="bi bi-exclamation-circle me-2"
                                   style="color: #6F1D46;"></i>
                                Motivo del bloqueo
                            </span>

                            <span class="text-muted">
                                Posible extracción masiva de información.
                            </span>
                        </div>

                        <hr>

                        <div>
                            <span class="fw-semibold d-block mb-1">
                                <i class="bi bi-clock-history me-2"
                                   style="color: #6F1D46;"></i>
                                Tiempo restante del bloqueo
                            </span>

                            <span class="fs-4 fw-bold" style="color: #6F1D46;">
                                {{ $minutosRestantes }} minutos
                            </span>
                        </div>

                    </div>

                    <div class="alert alert-warning border-0 small">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        El acceso a las exportaciones permanecerá restringido
                        hasta que finalice el periodo de bloqueo establecido.
                    </div>

                    <div class="text-center mt-4">

                        <a href="{{ route('dashboard') }}"
                           class="btn text-white px-4 py-2"
                           style="background-color: #6F1D46;">

                            <i class="bi bi-arrow-left me-2"></i>
                            Regresar al panel

                        </a>

                    </div>

                </div>

            </div>

            <p class="text-center text-muted mt-3 small">
                Sistema de monitoreo y protección de información
            </p>

        </div>
    </div>

</div>

@endsection