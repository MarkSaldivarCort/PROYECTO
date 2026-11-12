
@extends('layouts.app')

@section('title', 'Detalle de alerta')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Detalles de la alerta #{{ $alerta->id }}
            </h2>

            <p class="text-muted mb-0">
                Información técnica del evento registrado por Suricata.
            </p>
        </div>

        <a href="{{ route('alertas') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Volver a alertas

        </a>

    </div>

    {{-- Información de la alerta --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header text-white py-3"
             style="background-color: #6F1D46;">

            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-shield-exclamation me-2"></i>
                Información completa del evento Suricata
            </h5>

        </div>

        <div class="card-body p-4">

            {{-- Clasificación --}}
            <div class="mb-4">

                <h6 class="fw-bold mb-2">
                    Clasificación de la alerta
                </h6>

                @if($alerta->sid == 1000001)

                    <span class="badge bg-warning text-dark fs-6">
                        Exportación masiva de empleados
                    </span>

                @elseif($alerta->sid == 1000002)

                    <span class="badge bg-danger fs-6">
                        Exposición de datos personales (RFC)
                    </span>

                @elseif($alerta->sid == 1000003)

                    <span class="badge bg-warning text-dark fs-6">
                        Consulta masiva de fichas
                    </span>

                @elseif($alerta->sid == 1000004)

                    <span class="badge bg-danger fs-6">
                        Posible SQL Injection
                    </span>

                @else

                    <span class="badge bg-secondary fs-6">
                        Otra alerta
                    </span>

                @endif

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr style="background-color: #6F1D46; color: white;">
                            <th style="width: 30%;">Campo</th>
                            <th>Información registrada</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <th>ID</th>
                            <td>{{ $alerta->id }}</td>
                        </tr>

                        <tr>
                            <th>Flow ID</th>
                            <td>{{ $alerta->flow_id ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>IP de origen</th>
                            <td>{{ $alerta->src_ip ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>IP de destino</th>
                            <td>{{ $alerta->dest_ip ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>Firma de Suricata</th>
                            <td>{{ $alerta->signature ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>Severidad</th>
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
                        </tr>

                        <tr>
                            <th>SID</th>
                            <td>{{ $alerta->sid ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>Tipo de evento</th>
                            <td>{{ $alerta->event_type ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>Método HTTP</th>
                            <td>{{ $alerta->http_method ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>URL solicitada</th>
                            <td class="text-break">
                                {{ $alerta->http_url ?? 'No disponible' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Estado HTTP</th>
                            <td>{{ $alerta->http_status ?? 'No disponible' }}</td>
                        </tr>

                        <tr>
                            <th>Fecha del evento</th>
                            <td>{{ $alerta->fecha_evento ?? 'No disponible' }}</td>
                        </tr>

                        {{-- Atributos adicionales --}}
                        @foreach($alerta->getAttributes() as $campo => $valor)

                            @if(!in_array($campo, [
                                'id',
                                'flow_id',
                                'src_ip',
                                'dest_ip',
                                'signature',
                                'severity',
                                'sid',
                                'event_type',
                                'http_method',
                                'http_url',
                                'http_status',
                                'fecha_evento'
                            ]))

                                <tr>
                                    <th>{{ $campo }}</th>
                                    <td class="text-break">
                                        {{ $valor ?? 'No disponible' }}
                                    </td>
                                </tr>

                            @endif

                        @endforeach

                    </tbody>

                </table>

            </div>

            <!-- <div class="d-flex justify-content-end mt-4">

                <a href="{{ route('alertas') }}"
                   class="btn text-white px-4"
                   style="background-color: #6F1D46;">

                    <i class="bi bi-arrow-left me-2"></i>
                    Regresar al centro de alertas

                </a>

            </div> -->

        </div>

    </div>

</div>

@endsection
