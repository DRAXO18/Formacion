@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="container">
                        <h1 class="text-center mb-4">Historial de Ventas</h1>

                        <!-- Formulario de filtro y búsqueda -->
                        <form action="{{ route('historial.index') }}" method="GET">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="orden_fecha">Ordenar por Fecha:</label>
                                        <select class="form-control" name="orden_fecha" id="orden_fecha">
                                            <option value="recientes" {{ Request::get('orden_fecha') == 'recientes' ? 'selected' : '' }}>Más Recientes</option>
                                            <option value="antiguas" {{ Request::get('orden_fecha') == 'antiguas' ? 'selected' : '' }}>Más Antiguas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="busqueda">Buscar por ID de Venta, Nombre de Usuario o Fecha:</label>
                                        <input type="text" class="form-control" name="busqueda" id="busqueda" value="{{ Request::get('busqueda') }}" placeholder="Escriba aquí para buscar...">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Lista de Ventas -->
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach ($ventas as $venta)
                                <div class="col mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-body">
                                            <h5 class="card-title">Venta #{{ $venta->id }}</h5>
                                            <p class="card-text">Cliente: {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
                                            <p class="card-text">Usuario: {{ $venta->usuario->nombre }} {{ $venta->usuario->apellido }}</p>
                                            <p class="card-text">Fecha de Venta: {{ $venta->fecha_venta }}</p>
                                            <button class="btn btn-info btn-sm ver-detalles" data-bs-toggle="modal"
                                                data-bs-target="#detallesModal" data-id="{{ $venta->id }}">Ver Detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal -->
<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesModalLabel">Detalles de la Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID Detalle Venta</th>
                            <th>ID Producto</th>
                            <th>Nombre Producto</th>
                            <th>Marca Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detallesBody">
                        <!-- Los detalles de la venta se cargarán aquí mediante AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    $(document).ready(function() {
        $('.ver-detalles').on('click', function() {
            var ventaId = $(this).data('id');
            cargarDetallesVenta(ventaId);
        });

        function cargarDetallesVenta(ventaId) {
            $.ajax({
                url: '/historial/detalles/' + ventaId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    mostrarDetallesVenta(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function mostrarDetallesVenta(detalles) {
            var detallesHtml = '';
            detalles.forEach(function(detalle) {
                detallesHtml += `
                    <tr>
                        <td>${detalle.id}</td>
                        <td>${detalle.producto.id}</td>
                        <td>${detalle.producto.nombre}</td>
                        <td>${detalle.producto.marca.nombre_marca}</td>
                        <td>${detalle.producto.precio}</td>
                        <td>${detalle.cantidad}</td>
                        <td>${detalle.subtotal}</td>
                    </tr>`;
            });
            $('#detallesBody').html(detallesHtml);
        }

        $('#orden_fecha').change(function() {
            $('form').submit();
        });

        $('#busqueda').on('input', function() {
            var searchValue = $(this).val().toLowerCase().trim();

            $('.card').each(function() {
                var idVenta = $(this).find('.card-title').text().toLowerCase().trim();
                var clienteNombre = $(this).find('.card-text:nth-child(2)').text().toLowerCase().trim();
                var usuarioNombre = $(this).find('.card-text:nth-child(3)').text().toLowerCase().trim();
                var fechaVenta = $(this).find('.card-text:nth-child(4)').text().toLowerCase().trim();

                if (idVenta.includes(searchValue) || clienteNombre.includes(searchValue) || usuarioNombre.includes(searchValue) || fechaVenta.includes(searchValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

@endsection