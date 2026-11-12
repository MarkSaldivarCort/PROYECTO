@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card shadow-lg border-0"
                 style="background-color: #212529; color: white;">

                <div class="card-body p-5">

                    <h2 class="fw-bold mb-4 text-danger">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        Exportación bloqueada
                    </h2>

                    <h3 class="fw-bold mb-4">
                        Operación bloqueada por DLP
                    </h3>

                    <p class="fs-5">
                        La solicitud no cumple con la política de seguridad.
                    </p>

                    <p class="fs-5">
                        <strong>Nivel de riesgo:</strong>
                        <span class="text-danger fw-bold">ALTO</span>
                    </p>

                    <p class="fs-5">
                        <strong>Motivo:</strong>
                        Posible extracción masiva de información.
                    </p>

                    <p class="fs-5">
                        <strong>Tiempo restante:</strong>
                        {{ $minutosRestantes }} minutos.
                    </p>

                    <div class="mt-5">
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-outline-light px-4">
                            <i class="bi bi-arrow-left me-2"></i>
                            Regresar
                        </a>
                    </div>

                </div>
            </div>

            <p class="text-center text-muted mt-4">
                Prototipo académico - datos ficticios
            </p>

        </div>
    </div>
</div>

@endsection
