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
                                <h4>Productos</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lexa</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Productos</a></li>
                                    <li class="breadcrumb-item active">Lista de Productos</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Lista de Productos</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Código</th>
                                                <th>Marca</th>
                                                <th>Precio</th>
                                                <th>Foto</th> <!-- Nueva columna para mostrar la foto -->
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productos as $producto)
                                                <tr>
                                                    <td>{{ $producto->id }}</td>
                                                    <td>{{ $producto->nombre }}</td>
                                                    <td>{{ $producto->codigo }}</td>
                                                    <td>{{ $producto->marca->nombre_marca }}</td>
                                                    <td>{{ $producto->precio }}</td>
                                                    <td>
                                                        @if ($producto->foto)
                                                            <img src="{{ asset('storage/' . $producto->foto) }}"
                                                                alt="Foto del producto" style="max-width: 100px;">
                                                        @else
                                                            No disponible
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-vertical">
                                                            <button type="button" class="btn btn-sm btn-primary mb-2"
                                                                onclick="traerDatos({{ $producto->id }})" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">Editar</button>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="setDeleteFormAction({{ $producto->id }})"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal">Eliminar</button>
                                                        </div>
                                                    
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table img {
    width: 150px; /* Ajusta el ancho de la imagen */
    height: 100px; /* Ajusta la altura de la imagen */
    object-fit: cover; /* Ajusta la imagen para cubrir el área sin distorsionar */
}
    </style>

    <!-- Modal Editar Producto -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductoForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="producto_id" name="producto_id">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo">
                        </div>
                        <div class="mb-3">
                            <label for="idMarca" class="form-label">Marca</label>
                            <select class="form-select" id="idMarca" name="idMarca">
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->nombre_marca }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="precio" name="precio">
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="editProductoBtn">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function traerDatos(id) {
            $.ajax({
                type: 'GET',
                url: '/productos/' + id,
                success: function(data) {
                    $('#producto_id').val(data.id);
                    $('#nombre').val(data.nombre);
                    $('#codigo').val(data.codigo);
                    $('#idMarca').val(data.idMarca);
                    $('#precio').val(data.precio);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $('#editProductoBtn').click(function() {
            var productoId = $('#producto_id').val();
            var formData = new FormData($('#editProductoForm')[0]);

            $.ajax({
                type: 'POST',
                url: '/productos/' + productoId,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    var errors = xhr.responseJSON.errors;
                    for (var error in errors) {
                        console.error(errors[error]);
                    }
                }
            });
        });

        function setDeleteFormAction(id) {
            $('#confirmDelete').off('click').on('click', function() {
                $.ajax({
                    url: '/productos/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        $('#deleteModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        location.reload();
                    }
                });
            });
        }
    </script>
@endsection
