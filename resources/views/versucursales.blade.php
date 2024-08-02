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
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tiendas as $tienda)
                                            <tr>
                                                <td>{{ $tienda->id }}</td>
                                                <td>{{ $tienda->nombre_tienda }}</td>
                                                <td>{{ $tienda->direccion }}</td>
                                                <td>
                                                    <div class="d-flex flex-column gap-2">
                                                        <button type="button" class="btn btn-sm btn-info" onclick="toggleDetails({{ $tienda->id }})">Ver Detalles</button>
                                                        <form action="{{ route('sucursales.destroy', $tienda->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta tienda?')">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Details and Edit View -->
                                            <tr id="details-row-{{ $tienda->id }}" class="d-none">
                                                <td colspan="4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div id="details-content-{{ $tienda->id }}">
                                                                <!-- Display Details -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <h5 class="card-title">{{ $tienda->nombre_tienda }}</h5>
                                                                        <p><strong>Dirección:</strong> {{ $tienda->direccion }}</p>
                                                                        <p><strong>Código Postal:</strong> {{ $tienda->ubigeo ? $tienda->ubigeo->codigo_postal : 'No asignado' }}</p>
                                                                        <p><strong>Ubigeo:</strong> {{ $tienda->ubigeo ? $tienda->ubigeo->departamento . ' - ' . $tienda->ubigeo->provincia . ' - ' . $tienda->ubigeo->distrito : 'No asignado' }}</p>
                                                                        <button type="button" class="btn btn-sm btn-primary" onclick="editDetails({{ $tienda->id }})">Editar</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="position-relative">
                                                                            @if($tienda->foto)
                                                                                <img id="foto-preview-{{ $tienda->id }}" src="{{ asset('storage/tiendas/' . $tienda->foto) }}" alt="{{ $tienda->nombre_tienda }}" style="width: 150px; height: auto;">
                                                                            @else
                                                                                No disponible
                                                                            @endif
                                                                            <button type="button" class="btn btn-sm btn-secondary position-absolute end-0 bottom-0 m-2" onclick="showFileInput({{ $tienda->id }})">Cambiar Foto</button>
                                                                        </div>
                                                                        <input type="file" id="foto-input-{{ $tienda->id }}" class="d-none" onchange="previewImage(this, {{ $tienda->id }})">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Editable Form -->
                                                            <div id="edit-content-{{ $tienda->id }}" class="d-none">
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
                                                                    <button type="button" class="btn btn-secondary" onclick="cancelEdit({{ $tienda->id }})">Cancelar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <script>
                                                let openDetailId = null;

                                                function toggleDetails(id) {
                                                    // Close previously opened details
                                                    if (openDetailId && openDetailId !== id) {
                                                        document.getElementById('details-row-' + openDetailId).classList.add('d-none');
                                                        document.getElementById('edit-content-' + openDetailId).classList.add('d-none');
                                                        document.getElementById('details-content-' + openDetailId).classList.remove('d-none');
                                                    }
                                                    // Toggle current details
                                                    const row = document.getElementById('details-row-' + id);
                                                    row.classList.toggle('d-none');

                                                    if (row.classList.contains('d-none')) {
                                                        openDetailId = null;
                                                    } else {
                                                        openDetailId = id;
                                                    }
                                                }

                                                function editDetails(id) {
                                                    document.getElementById('details-content-' + id).classList.add('d-none');
                                                    document.getElementById('edit-content-' + id).classList.remove('d-none');
                                                }

                                                function showFileInput(id) {
                                                    document.getElementById('foto-input-' + id).click();
                                                }

                                                function previewImage(input, id) {
                                                    const file = input.files[0];
                                                    if (file) {
                                                        const reader = new FileReader();
                                                        reader.onload = function(e) {
                                                            document.getElementById('foto-preview-' + id).src = e.target.result;
                                                        };
                                                        reader.readAsDataURL(file);
                                                    }
                                                }

                                                function cancelEdit(id) {
                                                    document.getElementById('details-content-' + id).classList.remove('d-none');
                                                    document.getElementById('edit-content-' + id).classList.add('d-none');
                                                }
                                            </script>
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
