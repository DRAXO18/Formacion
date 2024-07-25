@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="page-title-box">
                                <h4>Asignar Rol a Usuario</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lexa</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                                    <li class="breadcrumb-item active">Asignar Rol</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <h2>Asignar Rol a Usuario</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol Asignado</th> <!-- Nueva columna para el rol asignado -->
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->rol ? $usuario->rol->nombre : 'No asignado' }}</td> <!-- Mostrar rol asignado -->
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asignarRolModal" data-usuario-id="{{ $usuario->id }}">
                                        Asignar Rol
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal para asignar rol -->
                    <div class="modal fade" id="asignarRolModal" tabindex="-1" aria-labelledby="asignarRolModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="asignarRolModalLabel">Asignar Rol</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="asignarRolForm" method="POST" action="{{ route('asignar-rol.store') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id_usuario" id="usuario_id" value="">
                                        <div class="mb-3">
                                            <label for="rol" class="form-label">Rol</label>
                                            <select class="form-select" id="rol" name="id_rol" required>
                                                @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Asignar Rol</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var asignarRolModal = document.getElementById('asignarRolModal');
                        asignarRolModal.addEventListener('show.bs.modal', function(event) {
                            var button = event.relatedTarget;
                            var usuarioId = button.getAttribute('data-usuario-id');
                            var modal = asignarRolModal.querySelector('.modal-body #usuario_id');
                            modal.value = usuarioId;
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
