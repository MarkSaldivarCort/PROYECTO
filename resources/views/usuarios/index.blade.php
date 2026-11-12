
@extends('layouts.app')

@section('title', 'Gestión de usuarios')

@section('content')

<div class="container-fluid px-0">

    {{-- Encabezado --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Gestión de usuarios
        </h2>

        <p class="text-muted mb-0">
            Administración de las cuentas registradas en el sistema.
        </p>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}

            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ $errors->first() }}

            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabla de usuarios --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header text-white py-3"
             style="background-color: #6F1D46;">

            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-people me-2"></i>
                Usuarios registrados
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr style="background-color: #6F1D46; color: white;">
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Nombre de usuario</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>Tipo de usuario</th>
                            <th style="min-width: 230px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($usuarios as $u)

                            <tr>

                                <td class="text-muted">
                                    {{ $u->id }}
                                </td>

                                <td class="fw-semibold text-nowrap">
                                    {{ $u->nombres }} {{ $u->apellidos }}
                                </td>

                                <td>
                                    {{ $u->nombre_de_usuario }}
                                </td>

                                <td>
                                    {{ $u->email }}
                                </td>

                                <td>
                                    {{ $u->telefono ?? 'No disponible' }}
                                </td>

                                <td>

                                    @if($u->tipo_usuario === 'admin')

                                        <span class="badge bg-danger">
                                            Administrador
                                        </span>

                                    @elseif($u->tipo_usuario === 'colaborador')

                                        <span class="badge bg-info text-dark">
                                            Colaborador
                                        </span>

                                    @elseif(in_array($u->tipo_usuario, ['analista_rrhh', 'Analista de RRHH']))

                                        <span class="badge text-white"
                                              style="background-color: #6F1D46;">
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

                                        <label class="form-label small fw-semibold">
                                            Cambiar tipo de usuario
                                        </label>

                                        
                                        <select name="tipo_usuario"
                                            class="form-select form-select-sm mb-2 selector-rol"
                                            required>

                                            <option value="admin"
                                                {{ $u->tipo_usuario === 'admin' ? 'selected' : '' }}>
                                                Administrador
                                            </option>

                                            <option value="colaborador"
                                                {{ $u->tipo_usuario === 'colaborador' ? 'selected' : '' }}>
                                                Colaborador
                                            </option>

                                            <option value="analista_rrhh"
                                                {{ in_array($u->tipo_usuario, ['analista_rrhh', 'Analista de RRHH']) ? 'selected' : '' }}>
                                                Analista de RRHH
                                            </option>

                                        </select>

                                        {{-- Confirmación de contraseña --}}
                                        <div class="confirmacion-password" style="display: none;">

                                            <input type="password"
                                                name="password"
                                                class="form-control form-control-sm mb-2"
                                                placeholder="Contraseña de administrador"
                                                autocomplete="current-password">

                                            <small class="text-muted d-block mb-2">
                                                Confirma tu contraseña para autorizar el cambio de rol.
                                            </small>

                                        </div>

                                        <button type="submit"
                                                class="btn btn-sm text-white w-100"
                                                style="background-color: #6F1D46;">

                                            <i class="bi bi-save me-1"></i>
                                            Guardar cambios

                                        </button>


                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-5">

                                    <i class="bi bi-people fs-2 text-muted d-block mb-2"></i>

                                    <span class="text-muted">
                                        No hay usuarios registrados.
                                    </span>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Paginación --}}
        <div class="card-body">
            <div class="d-flex justify-content-center">
                {{ $usuarios->links() }}
            </div>
        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.selector-rol').forEach(function (select) {

        select.addEventListener('change', function () {

            const formulario = select.closest('form');

            const contenedor = formulario.querySelector(
                '.confirmacion-password'
            );

            const password = contenedor.querySelector(
                'input[name="password"]'
            );

            contenedor.style.display = 'block';

            password.required = true;

        });

    });

});
</script>




@endsection
