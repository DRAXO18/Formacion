@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="page-title-box">
                                <h4 class="mb-0">Marca</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lexa</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Marcas</a></li>
                                    <li class="breadcrumb-item active">Lista de Marcas</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h4 class="header-title">Lista de Marcas</h4>

                                    <!-- Search Form -->
                                    <form class="d-flex mb-3" id="searchForm">
                                        <input class="form-control me-2" type="search" placeholder="Buscar"
                                            aria-label="Buscar" name="search">
                                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                    </form>

                                    <table id="marcasTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre de la Marca</th>
                                                <th>Proveedor</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($marcas as $marca)
                                                <tr>
                                                    <td>{{ $marca->nombre_marca }}</td>
                                                    <td>{{ $marca->proveedor }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm btn-edit"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            data-marca-id="{{ $marca->id }}">Editar</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Marca
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editMarcaForm">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" id="marca_id" name="marca_id">
                                                        <div class="form-group">
                                                            <label for="nombre_marca">Nombre de la Marca</label>
                                                            <input type="text" class="form-control" id="nombre_marca"
                                                                name="nombre_marca">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="proveedor">Proveedor</label>
                                                            <input type="text" class="form-control" id="proveedor"
                                                                name="proveedor">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-primary" id="editMarcaBtn">Guardar
                                                        Cambios</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Éxito</strong>
                    <small>Ahora</small>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    La marca se actualizo con exito
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Función para procesar el formulario de búsqueda
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                // Realizar la búsqueda por AJAX
                $.ajax({
                    type: 'GET',
                    url: '{{ route('marcas.index') }}', // Ajusta la ruta según tu configuración
                    data: formData,
                    success: function(response) {
                        // Actualizar la tabla con los resultados de la búsqueda
                        $('#marcasTable tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Función para obtener datos de la marca y llenar el modal para editar
            $('.btn-edit').on('click', function() {
                var marcaId = $(this).data('marca-id');

                $.ajax({
                    type: 'GET',
                    url: '{{ route('marcas.show', ':id') }}'.replace(':id', marcaId),
                    success: function(data) {
                        $('#marca_id').val(data.id);
                        $('#nombre_marca').val(data.nombre_marca);
                        $('#proveedor').val(data.proveedor);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Función para guardar los cambios al hacer clic en Guardar Cambios
            $('#editMarcaBtn').on('click', function() {
                var marcaId = $('#marca_id').val();
                var formData = $('#editMarcaForm').serialize();

                $.ajax({
                    type: 'PUT', // Método HTTP para actualizar
                    url: '/marcas/' + marcaId, // Ruta para actualizar la marca
                    data: formData,
                    success: function(response) {
                        $('#exampleModal').modal('hide');
                        // location.reload(); 
                        if (response.success) {
                var toastEl = new bootstrap.Toast(document.getElementById('successToast'));
                        toastEl.show();
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
            }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
