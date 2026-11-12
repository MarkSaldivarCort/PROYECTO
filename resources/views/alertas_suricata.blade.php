@extends('layouts.app')

@section('title', 'Centro de Alertas DLP')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Centro de Alertas DLP
        </h2>

        <p class="text-muted mb-0">
            Supervisión de eventos de seguridad y posibles
            incidentes de fuga de información.
        </p>
    </div>

    {{-- Indicadores generales --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-3 mb-4">

        {{-- Estado del sistema --}}
        <div class="col">
            <div class="card border-0 shadow-sm h-100"
                 style="border-top: 4px solid #198754 !important;">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-semibold">
                            Estado del sistema
                        </span>

                        <i class="bi bi-shield-check fs-4 text-success"></i>
                    </div>

                    <h5 class="fw-bold text-success mb-0">
                        Monitoreando
                    </h5>
                </div>

            </div>
        </div>

        {{-- Alertas totales --}}
        <div class="col">
            <div class="card border-0 shadow-sm h-100"
                 style="border-top: 4px solid #6F1D46 !important;">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-semibold">
                            Alertas totales
                        </span>

                        <i class="bi bi-bell fs-4"
                           style="color: #6F1D46;"></i>
                    </div>

                    <h2 class="fw-bold mb-0"
                        style="color: #6F1D46;">
                        {{ $totalAlertas }}
                    </h2>
                </div>

            </div>
        </div>

        {{-- Alertas críticas --}}
        <div class="col">
            <div class="card border-0 shadow-sm h-100"
                 style="border-top: 4px solid #dc3545 !important;">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-semibold">
                            Alertas críticas
                        </span>

                        <i class="bi bi-exclamation-octagon fs-4 text-danger"></i>
                    </div>

                    <h2 class="fw-bold text-danger mb-0">
                        {{ $criticas }}
                    </h2>
                </div>

            </div>
        </div>

        {{-- Alertas altas --}}
        <div class="col">
            <div class="card border-0 shadow-sm h-100"
                 style="border-top: 4px solid #fd7e14 !important;">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-semibold">
                            Alertas altas
                        </span>

                        <i class="bi bi-exclamation-triangle fs-4"
                           style="color: #fd7e14;"></i>
                    </div>

                    <h2 class="fw-bold mb-0"
                        style="color: #fd7e14;">
                        {{ $altas }}
                    </h2>
                </div>

            </div>
        </div>

        {{-- Exportaciones detectadas --}}
        <div class="col">
            <div class="card border-0 shadow-sm h-100"
                 style="border-top: 4px solid #636569 !important;">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-semibold">
                            Exportaciones detectadas
                        </span>

                        <i class="bi bi-file-earmark-arrow-down fs-4"
                           style="color: #636569;"></i>
                    </div>

                    <h2 class="fw-bold mb-0"
                        style="color: #636569;">
                        {{ $exportaciones }}
                    </h2>
                </div>

            </div>
        </div>

    </div>

    
    {{-- Tabla de eventos DLP --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header text-white py-3"
             style="background-color: #6F1D46;">

            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-shield-exclamation me-2"></i>
                Eventos DLP detectados
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr style="background-color: #6F1D46; color: white;">

                            <th>ID</th>
                            <th>Fecha</th>
                            <th>SID</th>
                            <th>Alerta</th>
                            <th>Tipo</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Severidad</th>
                            <th>Detalles</th>

                        </tr>
                    </thead>

                    <tbody>

                    @forelse($alertas as $alerta)

                        <tr>

                            <td class="text-muted">
                                {{ $alerta->id }}
                            </td>

                            <td class="text-nowrap">
                                {{ $alerta->fecha_evento }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $alerta->sid }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                {{ $alerta->signature }}
                            </td>

                            <td>
                                @if($alerta->sid == 1000001)

                                    Exportación

                                @elseif($alerta->sid == 1000002)

                                    Exposición de RFC

                                @elseif($alerta->sid == 1000003)

                                    Scraping

                                @elseif($alerta->sid == 1000004)

                                    UNION SELECT

                                @endif
                            </td>

                            <td class="text-nowrap">
                                {{ $alerta->src_ip }}
                            </td>

                            <td class="text-nowrap">
                                {{ $alerta->dest_ip }}
                            </td>

                            <td>

                                @if($alerta->severity == 1)

                                    <span class="badge bg-danger">
                                        Crítica
                                    </span>

                                @elseif($alerta->severity == 2)

                                    <span class="badge text-dark"
                                          style="background-color: #fdba74;">
                                        Alta
                                    </span>

                                @elseif($alerta->severity == 3)

                                    <span class="badge bg-warning text-dark">
                                        Media
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Baja
                                    </span>

                                @endif

                            </td>

                            <td>
                                <a href="{{ route('alertas.show', $alerta->id) }}"
                                   class="btn btn-sm text-white text-nowrap"
                                   style="background-color: #6F1D46;">

                                    <i class="bi bi-eye me-1"></i>
                                    Ver detalles

                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center py-5">

                                <i class="bi bi-shield-check fs-2 text-muted d-block mb-2"></i>

                                <span class="text-muted">
                                    No se encontraron alertas.
                                </span>

                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Paginación --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $alertas->links() }}
    </div>

</div>

@endsection

