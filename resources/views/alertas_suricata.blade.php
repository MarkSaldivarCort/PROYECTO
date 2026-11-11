@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">
        Centro de Alertas DLP
    </h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Estado del Sistema
                    </h6>

                    <h4 class="text-success">
                        Monitoreando
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-primary shadow-sm">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Alertas Totales
                    </h6>

                    <h2 class="text-primary">
                        {{ $totalAlertas }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-danger shadow-sm">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Alertas Críticas
                    </h6>

                    <h2 class="text-danger">
                        {{ $criticas }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-danger shadow-sm">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Alertas Altas
                    </h6>

                    <h2 class="text-danger">
                        {{ $altas }}
                    </h2>

                </div>

            </div>

        </div>
        
        <div class="col-md-3">

            <div class="card border-warning shadow-sm">

                <div class="card-body text-center">

                    <h6 class="text-muted">
                        Exportaciones Detectadas
                    </h6>

                    <h2 class="text-warning">
                        {{ $exportaciones }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Eventos DLP Detectados

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-dark">

                        <tr>

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

                            <td>
                                {{ $alerta->id }}
                            </td>

                            <td>
                                {{ $alerta->fecha_evento }}
                            </td>

                            <td>
                                {{ $alerta->sid }}
                            </td>

                            <td>
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

                            <td>
                                {{ $alerta->src_ip }}
                            </td>

                            <td>
                                {{ $alerta->dest_ip }}
                            </td>

                            <td>

                                @if($alerta->severity == 1)
                                    Crítica
                                @elseif($alerta->severity == 2)
                                    Alta
                                @elseif($alerta->severity == 3)
                                    Media
                                @else
                                    Baja
                                @endif

                            </td>

                            <td>
                                <a href="{{ route('alertas.show', $alerta->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Ver detalles
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center p-4">

                                No se encontraron alertas.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<div class="mt-3 d-flex justify-content-center">
    {{ $alertas->links() }}
</div>
<!-- <div class="text-center text-muted mt-2">
    Mostrando {{ $alertas->firstItem() }}
    a {{ $alertas->lastItem() }}
    de {{ $alertas->total() }} alertas
</div> -->
@endsection
