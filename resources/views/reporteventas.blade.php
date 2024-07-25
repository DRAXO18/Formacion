@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="container mt-4">
                        <h1 class="mb-4">Reporte de Ventas</h1>

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('reportes.ventas.filtrar') }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="row">
                                        <!-- Filters: Marca, Producto, ID/Fecha -->
                                        <div class="col-md-3">
                                            <label for="marca_id" class="form-label">Filtrar por Marca:</label>
                                            <select name="marca_id" id="marca_id" class="form-select">
                                                <option value="">Seleccione una marca...</option>
                                                @foreach ($marcas as $marca)
                                                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="producto_id" class="form-label">Filtrar por Producto:</label>
                                            <select name="producto_id" id="producto_id" class="form-select">
                                                <option value="">Seleccione un producto...</option>
                                                @foreach ($productos as $producto)
                                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="buscar" class="form-label">Buscar por ID o Fecha de Venta:</label>
                                            <input type="text" name="buscar" id="buscar" class="form-control"
                                                placeholder="Buscar...">
                                        </div>
                                    </div>
                                </form>

                                <!-- Sales Report Table -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID Venta</th>
                                                        <th>ID Cliente</th>
                                                        <th>Fecha de Venta</th>
                                                        <th>Total</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ventas as $venta)
                                                        <tr>
                                                            <td>{{ $venta->id }}</td>
                                                            <td>{{ $venta->cliente_id }}</td>
                                                            <td>{{ $venta->fecha_venta }}</td>
                                                            <td>{{ $venta->total }}</td>
                                                            <td>
                                                                <a href="#" class="btn btn-info">Detalles</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Statistics Sidebar -->
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Estadísticas</h5>
                                                <ul class="list-group">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        Ventas Totales
                                                        <span
                                                            class="badge bg-primary rounded-pill">{{ $ventas->count() }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        Total Ventas
                                                        <span
                                                            class="badge bg-success rounded-pill">{{ $ventas->sum('total') }}</span>
                                                    </li>
                                                    <!-- Additional statistics can be added here -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Monthly Sales Chart -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Ventas por Mes</h4>
                                        <div id="ventasPorMesChart" style="height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Charts -->
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawGoogleChart);

                        function drawGoogleChart() {
                            $.ajax({
                                url: '{{ route('ventas.por_mes') }}',
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    var ventasPorMesData = [['Mes', 'Ventas Total']];
                                    data.forEach(function(row) {
                                        ventasPorMesData.push([getMonthName(row.mes), parseFloat(row.total)]);
                                    });

                                    var data = google.visualization.arrayToDataTable(ventasPorMesData);

                                    var options = {
                                        title: 'Ventas por Mes (2024)',
                                        legend: { position: 'top' },
                                        colors: ['#4285F4'],
                                        vAxis: { format: 'currency' }
                                    };

                                    var chart = new google.visualization.ColumnChart(document.getElementById('ventasPorMesChart'));
                                    chart.draw(data, options);
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }

                        function getMonthName(month) {
                            var monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                            return monthNames[month - 1];
                        }
                    </script>

                    <!-- Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        
                        $(document).ready(function() {
                            var ctx = document.getElementById('ventasPorMesCanvas').getContext('2d');
                            var ventasPorMesChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                                    datasets: [{
                                        label: 'Ventas por Mes',
                                        data: [12, 19, 3, 5, 2, 3],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
