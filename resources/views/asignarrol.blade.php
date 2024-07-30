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

                    <!-- Campo de búsqueda -->
                    <div class="mb-3">
                        <input type="text" id="buscador" class="form-control" placeholder="Busque por cualquier medio de registro">
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol Asignado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-usuarios">
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->rol ? $usuario->rol->nombre : 'No asignado' }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asignarRolModal" data-usuario-id="{{ $usuario->id }}" data-usuario-nombre="{{ $usuario->nombre }}" data-usuario-email="{{ $usuario->email }}">
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
                                    <h5 class="modal-title" id="asignarRolModalLabel">Asignar Rol a <span id="usuarioNombre"></span></h5>
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
                                        <div class="mb-3">
                                            <label for="usuario_email" class="form-label">Correo del Usuario</label>
                                            <input type="text" class="form-control" id="usuario_email" readonly>
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
                            var usuarioNombre = button.getAttribute('data-usuario-nombre');
                            var usuarioEmail = button.getAttribute('data-usuario-email');

                            // Actualizar los campos del modal
                            asignarRolModal.querySelector('.modal-body #usuario_id').value = usuarioId;
                            asignarRolModal.querySelector('.modal-body #usuario_email').value = usuarioEmail;
                            document.getElementById('usuarioNombre').textContent = usuarioNombre;
                        });

                        // AJAX para buscar usuarios
                        var buscador = document.getElementById('buscador');
                        buscador.addEventListener('input', function() {
                            var query = this.value;

                            if (query.length >= 3) {
                                // Realiza una petición AJAX al servidor
                                fetch('/buscar-usuarios', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ query: query })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Verifica si el elemento existe antes de intentar actualizarlo
                                    var tablaUsuarios = document.getElementById('tabla-usuarios');
                                    if (tablaUsuarios) {
                                        tablaUsuarios.innerHTML = '';

                                        data.forEach(function(usuario) {
                                            var row = `<tr>
                                                <td>${usuario.nombre}</td>
                                                <td>${usuario.email}</td>
                                                <td>${usuario.rol ? usuario.rol.nombre : 'No asignado'}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#asignarRolModal" data-usuario-id="${usuario.id}" data-usuario-nombre="${usuario.nombre}" data-usuario-email="${usuario.email}">
                                                        Asignar Rol
                                                    </button>
                                                </td>
                                            </tr>`;
                                            tablaUsuarios.innerHTML += row;
                                        });
                                    } else {
                                        console.error('Elemento con id "tabla-usuarios" no encontrado.');
                                    }
                                })
                                .catch(error => console.error('Error al buscar usuarios:', error));
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
