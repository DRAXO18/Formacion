@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Formulario de Compra</h4>
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form id="compraForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="proveedor_id" class="form-label">Proveedor</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="proveedor_nombre" name="proveedor_nombre" placeholder="Seleccionar Proveedor" readonly>
                                                <input type="hidden" id="proveedor_id" name="proveedor_id">
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#proveedorModal">Seleccionar Proveedor</button>
                                            </div>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                                            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label for="tipo_compra" class="form-label">Tipo de Compra</label>
                                            <select class="form-control" id="tipo_compra" name="tipo_compra" required>
                                                <option value="">--SELECCIONAR--</option>
                                                @foreach ($tipos_venta as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <label for="usuario_nombre" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" value="{{ Auth::user()->nombre }} ({{ Auth::user()->email }})" readonly>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#productoModal">Seleccionar Productos</button>
                                        </div>
                                    
                                        <table id="productosSeleccionados" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Subtotal</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    
                                        <div class="mb-3">
                                            <label for="total" class="form-label">Total</label>
                                            <input type="text" class="form-control" id="total" name="total" readonly>
                                        </div>
                                    
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Realizar Compra</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal para seleccionar proveedor -->
                    <div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="proveedorModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="proveedorModalLabel">Seleccionar Proveedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="searchProveedorForm">
                                        <div class="mb-3">
                                            <label for="searchProveedor" class="form-label">Buscar Proveedor por Nombre o
                                                Identificación</label>
                                            <input type="text" class="form-control" id="searchProveedor"
                                                placeholder="Nombre o Identificación del Proveedor">
                                        </div>
                                    </form>
                                    <table id="proveedoresTabla" class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Identificación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal para seleccionar producto -->
                    <div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productoModalLabel">Seleccionar Producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="searchProductoForm">
                                        <div class="mb-3">
                                            <label for="searchProducto" class="form-label">Buscar Producto</label>
                                            <input type="text" class="form-control" id="searchProducto"
                                                placeholder="Nombre del Producto">
                                        </div>
                                    </form>
                                    <table id="productosTabla" class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
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
                    La compra se ha realizado con éxito.
                </div>
            </div>
        </div>
    </div>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (if not already included) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para buscar proveedores por AJAX
        $('#searchProveedor').on('input', function() {
            var search = $(this).val();
            if (search.length >= 3) {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('realizacompras.buscarProveedores') }}',
                    data: {
                        search: search
                    },
                    success: function(response) {
                        var rows = '';
                        response.forEach(function(proveedor) {
                            rows += `<tr>
                                <td>${proveedor.id}</td>
                                <td>${proveedor.nombre}</td>
                                <td>${proveedor.numero_identificacion}</td>
                                <td><button type="button" class="btn btn-outline-primary btn-seleccionar"
                                    data-id="${proveedor.id}" data-nombre="${proveedor.nombre}">
                                    Seleccionar
                                </button></td>
                            </tr>`;
                        });
                        $('#proveedoresTabla tbody').html(rows);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                // Limpiar tabla de proveedores si no hay suficientes caracteres
                $('#proveedoresTabla tbody').empty();
            }
        });

        // Función para seleccionar proveedor
        $('#proveedoresTabla').on('click', '.btn-seleccionar', function() {
            var proveedorId = $(this).data('id');
            var proveedorNombre = $(this).data('nombre');
            $('#proveedor_id').val(proveedorId);
            $('#proveedor_nombre').val(proveedorNombre);
            $('#proveedorModal').modal('hide');
            $('.modal-backdrop').remove();
        });

        // Función para buscar productos por AJAX
        $('#searchProducto').on('input', function() {
            var search = $(this).val();
            if (search.length >= 3) {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('realizaventas.buscarProductos') }}',
                    data: {
                        search: search
                    },
                    success: function(response) {
                        // console.log(response); // Verifica qué tipo de datos recibes aquí

                        // Verifica si la respuesta es un objeto y si contiene un array de productos válidos
                        if (response && Array.isArray(response.productos)) {
                            var rows = '';
                            response.productos.forEach(function(producto) {
                                rows += `<tr>
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td>${producto.precio}</td>
                        <td><input type="number" class="form-control cantidad" value="1"></td>
                        <td><button type="button" class="btn btn-primary btn-agregar"
                            data-id="${producto.id}"
                            data-nombre="${producto.nombre}"
                            data-precio="${producto.precio}">
                            Agregar
                        </button></td>
                    </tr>`;
                            });
                            $('#productosTabla tbody').html(rows);
                        } else {
                            console.error('La respuesta no contiene un array de productos válido.');
                            // Puedes agregar más detalles de depuración aquí si es necesario
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                // Limpiar tabla de productos si no hay suficientes caracteres
                $('#productosTabla tbody').empty();
            }
        });

        // Función para agregar producto seleccionado
        $('#productosTabla').on('click', '.btn-agregar', function() {
            var productoId = $(this).data('id');
            var productoNombre = $(this).data('nombre');
            var productoPrecio = $(this).data('precio');
            var cantidad = $(this).closest('tr').find('.cantidad').val();

            if (cantidad > 0) {
                var subtotal = productoPrecio * cantidad;
                var exists = false;

                $('#productosSeleccionados tbody tr').each(function() {
                    var currentProductoId = $(this).data('id');
                    if (currentProductoId == productoId) {
                        var currentCantidad = $(this).find('.cantidad').val();
                        var newCantidad = parseInt(currentCantidad) + parseInt(cantidad);
                        var newSubtotal = productoPrecio * newCantidad;
                        $(this).find('.cantidad').val(newCantidad);
                        $(this).find('.subtotal').text(newSubtotal.toFixed(2));
                        exists = true;
                        return false;
                    }
                });

                if (!exists) {
                    var newRow = `<tr data-id="${productoId}">
                                    <td>${productoNombre}</td>
                                    <td><input type="number" class="form-control precio" value="${productoPrecio}"></td>
                                    <td><input type="number" class="form-control cantidad" value="${cantidad}"></td>
                                    <td class="subtotal">${subtotal.toFixed(2)}</td>
                                    <td><button type="button" class="btn btn-danger btn-eliminar">Eliminar</button></td>
                                  </tr>`;
                    $('#productosSeleccionados tbody').append(newRow);
                }

                actualizarTotal();
            } else {
                alert('La cantidad debe ser mayor a 0.');
            }
        });

        // Función para eliminar producto seleccionado
        $('#productosSeleccionados').on('click', '.btn-eliminar', function() {
            $(this).closest('tr').remove();
            actualizarTotal();
        });

        // Función para actualizar el subtotal cuando se edita el precio o la cantidad
        $('#productosSeleccionados').on('input', '.precio, .cantidad', function() {
            var row = $(this).closest('tr');
            var precio = parseFloat(row.find('.precio').val());
            var cantidad = parseInt(row.find('.cantidad').val());
            var subtotal = precio * cantidad;

            if (cantidad > 0 && precio > 0) {
                row.find('.subtotal').text(subtotal.toFixed(2));
                actualizarTotal();
            } else {

            }
        });

        // Función para actualizar el total
function actualizarTotal() {
    var total = 0;
    $('#productosSeleccionados tbody tr').each(function() {
        total += parseFloat($(this).find('.subtotal').text());
    });
    $('#total').val(total.toFixed(2));
}

        $('#compraForm').submit(function(e) {
    e.preventDefault();

    var productos = [];
    $('#productosSeleccionados tbody tr').each(function() {
        var producto = {
            id: $(this).data('id'),
            nombre: $(this).find('td:eq(0)').text(),
            precio: $(this).find('.precio').val(),
            cantidad: $(this).find('.cantidad').val(),
            subtotal: $(this).find('.subtotal').text(),
        };
        productos.push(producto);
    });

    var formData = new FormData();
    formData.append('proveedor_id', $('#proveedor_id').val());
    formData.append('fecha_compra', $('#fecha_compra').val());
    formData.append('tipo_compra', $('#tipo_compra').val());

    // Añadir cada producto individualmente
    productos.forEach(function(producto, index) {
        formData.append(`productos[${index}][id]`, producto.id);
        formData.append(`productos[${index}][nombre]`, producto.nombre);
        formData.append(`productos[${index}][precio]`, producto.precio);
        formData.append(`productos[${index}][cantidad]`, producto.cantidad);
        formData.append(`productos[${index}][subtotal]`, producto.subtotal);
    });

    $.ajax({
        type: 'POST',
        url: '{{ route('realizacompras.guardarCompra') }}',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        success: function(response) {
            // Manejar la respuesta después de guardar la compra
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

    </script>
@endsection
