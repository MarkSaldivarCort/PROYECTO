@extends('layouts.app')

@section('content')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Gestión de usuarios</h2>
            <p class="text-muted mb-0">
                Administración de las cuentas registradas en el sistema.
            </p>
        </div>
    </div>

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            Usuarios registrados
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Nombre de usuario</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>Tipo de usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($usuarios as $u)

                            <tr>
                                <td>{{ $u->id }}</td>

                                <td>
                                    {{ $u->nombres }} {{ $u->apellidos }}
                                </td>

                                <td>{{ $u->nombre_de_usuario }}</td>

                                <td>{{ $u->email }}</td>

                                <td>{{ $u->telefono ?? 'No disponible' }}</td>

                                <td>
                                    @if($u->tipo_usuario === 'admin')
                                        <span class="badge bg-danger">
                                            Administrador
                                        </span>
                                    @elseif($u->tipo_usuario === 'colaborador')
                                        <span class="badge bg-info">
                                            Colaborador
                                        </span>
                                    @elseif(in_array($u->tipo_usuario, ['analista_rrhh', 'Analista de RRHH']))
                                        <span class="badge bg-primary">
                                            Analista de RRHH
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $u->tipo_usuario }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('usuarios.actualizarRol', $u->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <select name="tipo_usuario" class="form-select form-select-sm mb-2" required>

                                            <option value="admin" {{ $u->tipo_usuario === 'admin' ? 'selected' : '' }}>
                                                Administrador
                                            </option>

                                            <option value="colaborador" {{ $u->tipo_usuario === 'colaborador' ? 'selected' : '' }}>
                                                Colaborador
                                            </option>

                                            <option value="analista_rrhh" {{ in_array($u->tipo_usuario, ['analista_rrhh', 'Analista de RRHH']) ? 'selected' : '' }}>
                                                Analista de RRHH
                                            </option>

                                        </select>

                                        <input type="password"
                                            name="password"
                                            class="form-control form-control-sm mb-2"
                                            placeholder="Tu contraseña de administrador"
                                            autocomplete="current-password"
                                            required>

                                        <button type="submit" class="btn btn-sm btn-primary w-100">
                                            Guardar cambios
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No hay usuarios registrados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $usuarios->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
