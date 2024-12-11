@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg rounded-lg bg-light border-0">
                            <div class="card-body p-5">
                                <h3 class="header-title text-center text-primary mb-4">
                                    <i class="bi bi-receipt"></i> Formulario de Compra
                                </h3>
                                @if (session('success'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form id="compraForm" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="proveedor_id" class="form-label fw-bold">Proveedor</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="proveedor_nombre" name="proveedor_nombre" placeholder="Seleccionar Proveedor" readonly>
                                                <input type="hidden" id="proveedor_id" name="proveedor_id">
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#proveedorModal">
                                                    <i class="bi bi-search"></i> Seleccionar
                                                </button>
                                                <button type="button" class="btn btn-dark ms-2" data-bs-toggle="modal" data-bs-target="#nuevoProveedorModal">
                                                    <i class="bi bi-person-plus"></i> Añadir
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="fecha_compra" class="form-label fw-bold">Fecha de Compra</label>
                                            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="tipo_compra" class="form-label fw-bold">Tipo de Compra</label>
                                            <select class="form-control" id="tipo_compra" name="tipo_compra" required>
                                                <option value="" disabled selected>--SELECCIONAR--</option>
                                                @foreach ($tipos_venta as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="usuario_nombre" class="form-label fw-bold">Usuario</label>
                                            <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" value="{{ Auth::user()->nombre }} ({{ Auth::user()->email }})" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-4 text-center">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#productoModal">
                                            <i class="bi bi-box-seam"></i> Seleccionar Productos
                                        </button>
                                    </div>

                                    <div class="table-responsive mb-4">
                                        <table id="productosSeleccionados" class="table table-striped table-hover">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Subtotal</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Productos seleccionados se añaden aquí -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mb-4 justify-content-center">
                                        <div class="col-md-4">
                                            <label for="total" class="form-label fw-bold">Total</label>
                                            <input type="text" class="form-control text-end" id="total" name="total" readonly>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-check-circle"></i> Realizar Compra
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para añadir proveedor -->
                <div class="modal fade" id="nuevoProveedorModal" tabindex="-1" aria-labelledby="nuevoProveedorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="nuevoProveedorModalLabel"><i class="bi bi-person-plus"></i> Añadir Proveedor</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="nuevoProveedorForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label fw-bold">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="idtipo_documento" class="form-label fw-bold">Tipo de Documento</label>
                                        <select class="form-control" id="idtipo_documento" name="idtipo_documento" required>
                                            <option value="" disabled selected>Seleccionar Tipo de Documento</option>
                                            @foreach($tiposDocumentos as $tipoDocumento)
                                                <option value="{{ $tipoDocumento->id }}">{{ $tipoDocumento->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_identificacion" class="form-label fw-bold">Número de Identificación</label>
                                        <input type="text" class="form-control" id="numero_identificacion" name="numero_identificacion" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label fw-bold">Foto de Perfil</label>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para seleccionar proveedor -->
                <div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="proveedorModalLabel"><i class="bi bi-search"></i> Seleccionar Proveedor</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="searchProveedorForm">
                                    <div class="mb-3">
                                        <label for="searchProveedor" class="form-label fw-bold">Buscar Proveedor</label>
                                        <input type="text" class="form-control" id="searchProveedor" placeholder="Nombre o Identificación del Proveedor">
                                    </div>
                                </form>
                                <table id="proveedoresTabla" class="table table-striped mt-3">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Identificación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Proveedores serán listados aquí -->
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
                <div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="productoModalLabel"><i class="bi bi-box-seam"></i> Seleccionar Producto</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="searchProductoForm">
                                    <div class="mb-3">
                                        <label for="searchProducto" class="form-label fw-bold">Buscar Producto</label>
                                        <input type="text" class="form-control" id="searchProducto" placeholder="Nombre del Producto">
                                    </div>
                                </form>
                                <table id="productosTabla" class="table table-striped mt-3">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Productos serán listados aquí -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toast de éxito -->
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

            </div>
        </div>
    </div>
</div>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
// Función para buscar proveedores por AJAX
$('#searchProveedor').on('input', function() {
    var search = $(this).val();
    if (search.length >= 3) {
        $.ajax({
            type: 'GET',
            url: '{{ route('realizacompras.buscarProveedores') }}',
            data: { search: search },
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
            data: { search: search },
            success: function(response) {
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
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    } else {
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
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        contentType: false,
        processData: false,
        success: function(response) {
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

$(document).ready(function() {
    $('#nuevoProveedorForm').on('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '{{ route("realizacompras.guardarProveedor") }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.success) {
                    alert('Proveedor añadido exitosamente');
                    var nuevoProveedor = response.proveedor;
                    $('#proveedor_nombre').val(nuevoProveedor.nombre + ' ' + nuevoProveedor.apellido);
                    $('#proveedor_id').val(nuevoProveedor.id);
                    var modalEl = document.getElementById('nuevoProveedorModal');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                } else {
                    var errorMessage = '';
                    if (response.errors) {
                        for (const [field, messages] of Object.entries(response.errors)) {
                            if (field === 'numero_identificacion') {
                                errorMessage += 'El número de identificación ya está en uso. Por favor, usa otro.\n';
                            } else {
                                errorMessage += `${field}: ${messages.join(', ')}\n`;
                            }
                        }
                    } else {
                        errorMessage = 'Hubo un error al añadir el proveedor';
                    }
                    alert(errorMessage);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Hubo un error al procesar la solicitud');
            }
        });
    });

    $('#nuevoProveedorModal').on('show.bs.modal', function () {
        $('#tipo_usuario').val(2);
    });
});
</script>
@endsection
