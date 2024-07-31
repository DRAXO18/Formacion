@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                {{-- <div class="row">
                    <div class="col-sm-4">
                        <div class="page-title-box">
                            <h4 class="text-primary">Stock</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Lexa</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Estock</a></li>
                                <li class="breadcrumb-item active">Actualizar Stock</li>
                            </ol>
                        </div>
                    </div>
                </div> --}}
                <div class="container">
                    <h2 class="mb-4 text-center text-dark">Gestión de Stock</h2>
                    <div class="row mb-3">
                        {{-- <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="productSearch" class="form-control" placeholder="Buscar producto">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-magnify"></i>
                                    </span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <select id="brandFilter" class="form-control">
                                <option value="">Filtrar por marca</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->nombre_marca }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-hover" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Producto</th>
                                    <th>Marca del Producto</th>
                                    <th>Cantidad</th>
                                    <th>Stock Actual</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                @foreach ($productos as $producto)
                                <tr data-id="{{ $producto->id }}" data-brand="{{ $producto->idMarca }}">
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->marca->nombre_marca }}</td>
                                    <td>
                                        <input type="number" class="form-control quantity" value="0">
                                    </td>
                                    <td>{{ $producto->stock }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-start mb-4">
                        <button id="updateStock" class="btn btn-primary btn-lg">Actualizar Stock</button>
                    </div>
                </div>
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <!-- Toasts se cargarán aquí dinámicamente -->
                    <div id="toastPlaceholder"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<!-- Custom CSS for additional styles -->
<style>
    .page-title-box {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }
    .breadcrumb {
        background: none;
        padding: 0;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table thead {
        background-color: #343a40;
        color: #fff;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .toast {
        border-radius: 8px;
    }
</style>

<script>
    $('#example').DataTable({
        "processing": true,
        "serverSide": false,
        "paging": true,
        "lengthMenu": [10, 25, 50, 75, 100],
        "pageLength": 10
    });

    $(document).ready(function() {
        function loadProducts(query, brandId) {
            $.ajax({
                url: '{{ route("operacionesstock.search") }}',
                method: 'GET',
                data: {
                    query: query,
                    brand_id: brandId
                },
                success: function(response) {
                    var tbody = $('#productTableBody');
                    tbody.empty();
                    if (response.length > 0) {
                        response.forEach(function(product) {
                            tbody.append(`
                                <tr data-id="${product.id}" data-brand="${product.idMarca}">
                                    <td>${product.id}</td>
                                    <td>${product.nombre}</td>
                                    <td>${product.marca.nombre_marca}</td>
                                    <td>
                                        <input type="number" class="form-control quantity" value="0">
                                    </td>
                                    <td>${product.stock}</td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">No se encontraron productos</td></tr>');
                    }
                }
            });
        }

        $('#productSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            loadProducts(value, $('#brandFilter').val());
        });

        $('#brandFilter').on('change', function() {
            loadProducts($('#productSearch').val(), $(this).val());
        });

        function showToast(message, type = 'success') {
            var toastPlaceholder = $('#toastPlaceholder');
            var toast = `
                <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            toastPlaceholder.append(toast);
            var toastElement = toastPlaceholder.find('.toast').last();
            var bsToast = new bootstrap.Toast(toastElement);
            bsToast.show();
            setTimeout(function() {
                toastElement.remove();
            }, 5000);
        }

        $('#updateStock').click(function() {
            var data = [];
            $('tbody tr').each(function() {
                var productId = $(this).data('id');
                var quantity = $(this).find('.quantity').val();
                if (quantity > 0) {
                    data.push({
                        idProducto: productId,
                        tipo_movimiento: 'entrada',
                        cantidad: quantity
                    });
                }
            });

            $.ajax({
                url: '{{ route("operacionesstock.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: data
                },
                success: function(response) {
                    if (response.success) {
                        showToast('Stock actualizado exitosamente.');
                        loadProducts($('#productSearch').val(), $('#brandFilter').val());
                    }
                },
                error: function() {
                    showToast('Hubo un error al actualizar el stock. Por favor, intenta de nuevo.', 'danger');
                }
            });
        });
    });
</script>

@endsection
