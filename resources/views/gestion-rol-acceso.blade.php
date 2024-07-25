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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Añadir Rol -->
<div class="modal fade" id="modalAñadirRol" tabindex="-1" aria-labelledby="modalAñadirRolLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAñadirRolLabel">Crear Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('rolesModal.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nombreRol" class="form-label">Nombre del Rol</label>
                        <input type="text" name="nombre" id="nombreRol" class="form-control"
                            value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Rol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Añadir Acceso -->
<div class="modal fade" id="modalAñadirAcceso" tabindex="-1" aria-labelledby="modalAñadirAccesoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAñadirAccesoLabel">Crear Nuevo Acceso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('accesosModal.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nombreAcceso" class="form-label">Nombre del Acceso</label>
                        <input type="text" name="nombre" id="nombreAcceso" class="form-control"
                            value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="controlador" class="form-label">Controlador</label>
                        <input type="text" name="controlador" id="controlador" class="form-control"
                            value="{{ old('controlador') }}" required>
                        @error('controlador')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="">Seleccionar Tipo</option>
                            <option value="acceso" {{ old('tipo') == 'acceso' ? 'selected' : '' }}>Acceso</option>
                            <option value="subacceso" {{ old('tipo') == 'subacceso' ? 'selected' : '' }}>Subacceso
                            </option>
                            <option value="opcion" {{ old('tipo') == 'opcion' ? 'selected' : '' }}>Opción</option>
                        </select>
                        @error('tipo')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Acceso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<style>
    /* Estilos personalizados para los checkboxes */
    .custom-checkbox-container {
        position: relative;
        padding-left: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .custom-checkbox-container .form-check-input {
        position: absolute;
        left: 0;
        top: 0.2rem;
        margin-left: 0;
        opacity: 0; /* Hacer el checkbox invisible por defecto */
    }

    .custom-checkbox-container .form-check-label {
        cursor: pointer;
        transition: color 0.3s, background-color 0.3s;
        position: relative;
        padding-left: 1.5rem;
    }

    .custom-checkbox-container .form-check-label::before {
        content: '';
        position: absolute;
        top: 0.1rem;
        left: 0;
        height: 1rem;
        width: 1rem;
        border-radius: 0.25rem;
        background-color: transparent;
        border: 1px solid #007bff;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .custom-checkbox-container .form-check-input:checked ~ .form-check-label::before {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .custom-checkbox-container .form-check-input:checked ~ .form-check-label::after {
        content: '\2713'; /* Checkmark */
        position: absolute;
        top: 0;
        left: 0;
        height: 1rem;
        width: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
</style>
@endsection
