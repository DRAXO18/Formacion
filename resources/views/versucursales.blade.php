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
                            <h4>Gestión de Tiendas</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Inicios</a></li>
                                <li class="breadcrumb-item active">Gestión de Tiendas</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Listado de Tiendas</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre de la Tienda</th>
                                            <th>Dirección</th>
                                            <th>Código Postal</th>
                                            <th>Ubigeo</th>
                                            <th>Imagen</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tiendas as $tienda)
                                            <tr>
                                                <td>{{ $tienda->id }}</td>
                                                <td>{{ $tienda->nombre_tienda }}</td>
                                                <td>{{ $tienda->direccion }}</td>
                                                <td>{{ $tienda->codigo_postal }}</td>
                                                <td>{{ $tienda->ubigeo ? $tienda->ubigeo->departamento . ' - ' . $tienda->ubigeo->distrito . ' - ' . $tienda->ubigeo->provincia : 'No asignado' }}</td>
                                                <td>
                                                    @if($tienda->foto)
                                                        <img src="{{ asset('storage/tiendas/' . $tienda->foto) }}" alt="{{ $tienda->nombre_tienda }}" style="width: 100px; height: auto;">
                                                    @else
                                                        No disponible
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $tienda->id }}">Editar</button>
                                                    <form action="{{ route('sucursales.destroy', $tienda->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta tienda?')">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $tienda->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $tienda->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $tienda->id }}">Editar Tienda</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('sucursales.update', $tienda->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="nombre_tienda{{ $tienda->id }}" class="form-label">Nombre de la Tienda</label>
                                                                    <input type="text" class="form-control" id="nombre_tienda{{ $tienda->id }}" name="nombre_tienda" value="{{ $tienda->nombre_tienda }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="direccion{{ $tienda->id }}" class="form-label">Dirección</label>
                                                                    <input type="text" class="form-control" id="direccion{{ $tienda->id }}" name="direccion" value="{{ $tienda->direccion }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="codigo_postal{{ $tienda->id }}" class="form-label">Código Postal</label>
                                                                    <input type="text" class="form-control" id="codigo_postal{{ $tienda->id }}" name="codigo_postal" value="{{ $tienda->codigo_postal }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="id_ubigeo{{ $tienda->id }}" class="form-label">Ubigeo</label>
                                                                    <select class="form-select" id="id_ubigeo{{ $tienda->id }}" name="id_ubigeo">
                                                                        <option value="">Seleccione</option>
                                                                        @foreach($ubigeos as $ubigeo)
                                                                            <option value="{{ $ubigeo->id }}" {{ $ubigeo->id == $tienda->id_ubigeo ? 'selected' : '' }}>
                                                                                {{ $ubigeo->departamento . ' - ' . $ubigeo->provincia . ' - ' . $ubigeo->distrito }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="foto{{ $tienda->id }}" class="form-label">Foto</label>
                                                                    <input type="file" class="form-control" id="foto{{ $tienda->id }}" name="foto">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Pagination -->
                                {{ $tiendas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
