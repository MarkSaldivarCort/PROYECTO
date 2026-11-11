
@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Detalles de la alerta #{{ $alerta->id }}</h2>

        <a href="{{ route('alertas') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a alertas
        </a>

    </div>

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            Información completa del evento Suricata
        </div>

        <div class="card-body">

            <div class="mb-3">

                <h5>Clasificación de la alerta</h5>

                @if($alerta->sid == 1000001)
                    <span class="badge bg-warning text-dark">
                        Exportación masiva de empleados
                    </span>
                @elseif($alerta->sid == 1000002)
                    <span class="badge bg-danger">
                        Exposición de datos personales (RFC)
                    </span>
                @elseif($alerta->sid == 1000003)
                    <span class="badge bg-warning text-dark">
                        Consulta masiva de fichas
                    </span>
                @elseif($alerta->sid == 1000004)
                    <span class="badge bg-danger">
                        Posible SQL Injection
                    </span>
                @else
                    <span class="badge bg-secondary">
                        Otra alerta
                    </span>
                @endif

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>Campo</th>
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
                                    Crítica
                                @elseif($alerta->severity == 2)
                                    Alta
                                @elseif($alerta->severity == 3)
                                    Media
                                @else
                                    Baja
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
                                    <td>{{ $valor ?? 'No disponible' }}</td>
                                </tr>

                            @endif

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
