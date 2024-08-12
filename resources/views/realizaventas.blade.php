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
                                <h4 class="header-title mb-3">Formulario de cardiaco</h4>
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <form id="ventaForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="cliente_id" class="form-label">Cliente</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" placeholder="Seleccionar Cliente" readonly>
                                            <input type="hidden" id="cliente_id" name="cliente_id">
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#clienteModal">Seleccionar Cliente</button><p>&nbsp;</p><p>&nbsp;</p>
                                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">Añadir Cliente</button>
                                            
                                        </div>                    
                    
                            </div>
                            <div class="mb-3">
                                <label for="fecha_venta" class="form-label">Fecha de Registro</label>
                                <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_venta" class="form-label">Tipo de Venta</label>
                                <select class="form-control" id="tipo_venta" name="tipo_venta" required>
                                    <option>--SELECCIONAR--</option>
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
                                <button type="submit" class="btn btn-primary">Realizar Venta</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal para seleccionar cliente -->
            <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clienteModalLabel">Seleccionar Cliente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="searchClienteForm">
                                <div class="mb-3">
                                    <label for="searchCliente" class="form-label">Buscar Cliente por Nombre o
                                        Identificación</label>
                                    <input type="text" class="form-control" id="searchCliente" placeholder="Nombre o Identificación del Cliente">
                                </div>
                            </form>
                            <table id="clientesTabla" class="table table-striped mt-3">
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

            <div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoClienteModalLabel">Añadir Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="nuevoClienteForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required autocomplete="name">
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required autocomplete="family-name">
                    </div>
                    <div class="mb-3">
                        <label for="idtipo_documento" class="form-label">Tipo de Documento</label>
                        <select class="form-control" id="idtipo_documento" name="idtipo_documento" required>
                            <option value="">Seleccionar Tipo de Documento</option>
                            @foreach($tiposDocumentos as $tipoDocumento)
                                <option value="{{ $tipoDocumento->id }}">{{ $tipoDocumento->nombre }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="mb-3">
    <label for="numero_identificacion" class="form-label">Número de Identificación</label>
    <input type="text" class="form-control" id="numero_identificacion" name="numero_identificacion" required autocomplete="off" maxlength="8">
    <span id="dniError" class="text-danger d-none">El DNI debe tener exactamente 8 dígitos.</span>
</div>
                    <div class="mb-3">
                        <input type="hidden" id="tipo_usuario" name="tipo_usuario" value="1"> <!-- Campo oculto con valor de Cliente -->
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
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



            <!-- Modal para seleccionar producto -->
            <div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productoModalLabel">Seleccionar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="searchProductoForm">
                                <div class="mb-3">
                                    <label for="searchProducto" class="form-label">Buscar Producto</label>
                                    <input type="text" class="form-control" id="searchProducto" placeholder="Nombre del Producto">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                La venta se ha realizado con éxito.
            </div>
        </div>
    </div>
</div>

{{-- <!-- Bootstrap y scripts adicionales -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}



<script>
    // Función para buscar clientes por AJAX
    $('#searchCliente').on('input', function() {
        var search = $(this).val();
        if (search.length >= 3) {
            $.ajax({
                type: 'GET',
                url: '{{ route('realizaventas.buscarUsuarios') }}',
                data: {
                    search: search
                },
                success: function(response) {
                    var rows = '';
                    response.forEach(function(user) {
                        rows += `<tr>
                                <td>${user.id}</td>
                                <td>${user.nombre} ${user.apellido}</td>
                                <td>${user.numero_identificacion}</td>
                                <td><button type="button" class="btn btn-outline-primary btn-seleccionar"
                                    data-id="${user.id}" data-nombre="${user.nombre} ${user.apellido}">
                                    Seleccionar
                                </button></td>
                            </tr>`;
                    });
                    $('#clientesTabla tbody').html(rows);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            // Limpiar tabla de clientes si no hay suficientes caracteres
            $('#clientesTabla tbody').empty();
        }
    });

    // Función para seleccionar cliente
    $('#clientesTabla').on('click', '.btn-seleccionar', function() {
        var clienteId = $(this).data('id');
        var clienteNombre = $(this).data('nombre');
        $('#cliente_id').val(clienteId);
        $('#cliente_nombre').val(clienteNombre);
        $('#clienteModal').modal('hide');
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

    $('#ventaForm').submit(function(e) {
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
        formData.append('cliente_id', $('#cliente_id').val());
        formData.append('fecha_venta', $('#fecha_venta').val());
        formData.append('tipo_venta', $('#tipo_venta').val());

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
            url: '{{ route('realizaventas.guardarVenta') }}',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            success: function(response) {
                // Manejar la respuesta después de guardar la venta
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
    $('#nuevoClienteForm').on('submit', function(event) {
        event.preventDefault(); // Previene el envío normal del formulario

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '{{ route("realizaventas.guardarCliente") }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Mostrar mensaje de éxito
                    alert('Cliente añadido exitosamente');

                    // Autorrellenar los campos en el formulario de ventas con el cliente recién añadido
                    var nuevoCliente = response.cliente;
                    $('#cliente_nombre').val(nuevoCliente.nombre + ' ' + nuevoCliente.apellido);
                    $('#cliente_id').val(nuevoCliente.id);

                    // Cierra el modal de añadir cliente
                    var modalEl = document.getElementById('nuevoClienteModal');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                } else {
                    var errorMessage = '';
                    if (response.errors) {
                        for (const [field, messages] of Object.entries(response.errors)) {
                            if(field === 'numero_identificacion') {
                                errorMessage += 'El número de identificación ya está en uso. Por favor, usa otro.\n';
                            } else {
                                errorMessage += `${field}: ${messages.join(', ')}\n`;
                            }
                        }
                    } else {
                        errorMessage = 'Hubo un error al añadir el cliente';
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

    // Código para manejar la selección de cliente desde el modal de selección de cliente (si fuera necesario)
    $('#clienteModal').on('show.bs.modal', function() {
        // Aquí podrías agregar lógica para listar clientes o manejar la selección del cliente
    });
});

document.addEventListener('DOMContentLoaded', function() {
        const dniInput = document.getElementById('numero_identificacion');
        const dniError = document.getElementById('dniError');

        dniInput.addEventListener('input', function() {
            const dniValue = dniInput.value;

            if (dniValue.length > 8) {
                dniError.classList.remove('d-none');
                dniInput.value = dniValue.slice(0, 8); // Limitar la longitud a 8 caracteres
            } else {
                dniError.classList.add('d-none');
            }
        });
    });



   
 


</script>
@endsection