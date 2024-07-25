@extends('layouts.app')

@section('content')
<br><br><br>
<div class="container mt-5" style="margin-left: 20%;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Gestión de Roles y Accesos</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('gestion-rol-acceso.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select name="id_rol" id="rol" class="form-select" required>
                                <option value="">Selecciona un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="accesos" class="form-label">Accesos</label>
                            <div id="accesos" class="form-control" style="height: auto; padding: 0;">
                                @foreach ($accesos as $acceso)
                                    <div class="form-check custom-checkbox-container">
                                        <input class="form-check-input" type="checkbox" name="id_accesos[]"
                                            value="{{ $acceso->id }}" id="acceso{{ $acceso->id }}">
                                        <label class="form-check-label" for="acceso{{ $acceso->id }}">
                                            {{ $acceso->nombre }} ({{ $acceso->tipo }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-left: 43%;">Guardar</button>
                    </form>
                    <div class="mt-4">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modalAñadirRol" style="margin-left: 36%;">
                            <i class="fas fa-plus"></i> Añadir Rol
                        </button>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#modalAñadirAcceso" style="margin-left: 1%;">
                            <i class="fas fa-plus"></i> Añadir Acceso
                        </button>
                    </div>

                    <div class="mt-4">
                        <h4>Lista de Roles</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rol</th>
                                    <th>Accesos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $rol)
                                    <tr>
                                        <td>{{ $rol->nombre }}</td>
                                        <td>
                                            @foreach ($rol->accesos as $acceso)
                                                <span class="badge bg-secondary">{{ $acceso->nombre }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditarRol{{ $rol->id }}">
                                                Editar
                                            </button>
                                            <form action="{{ route('gestion-rol-acceso.destroy', $rol->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este rol?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('partials.editarRol', ['rol' => $rol, 'accesos' => $accesos])
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Añadir Rol -->
                    <div class="modal fade" id="modalAñadirRol" tabindex="-1" aria-labelledby="modalAñadirRolLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAñadirRolLabel">Añadir Nuevo Rol</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('roles.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nombre_rol" class="form-label">Nombre del Rol</label>
                                            <input type="text" class="form-control" id="nombre_rol" name="nombre"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Añadir Acceso -->
                    <div class="modal fade" id="modalAñadirAcceso" tabindex="-1" aria-labelledby="modalAñadirAccesoLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAñadirAccesoLabel">Añadir Nuevo Acceso</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('accesos.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nombre_acceso" class="form-label">Nombre del Acceso</label>
                                            <input type="text" class="form-control" id="nombre_acceso" name="nombre"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tipo_acceso" class="form-label">Tipo de Acceso</label>
                                            <input type="text" class="form-control" id="tipo_acceso" name="tipo"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Editar Rol -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
