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
                            <h4 class="mb-3">Gestión de Tiendas</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión de Tiendas</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-light">
                            <div class="card-body">
                                <h4 class="header-title">Listado de Tiendas</h4>
                                <table class="table table-striped table-hover">
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
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="toggleDetails({{ $tienda->id }})">
                                                            <i class="fas fa-eye"></i> Ver Detalles
                                                        </button>
                                                        <form action="{{ route('sucursales.destroy', $tienda->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta tienda?')">
                                                                <i class="fas fa-trash-alt"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Details and Edit View -->
                                            <tr id="details-row-{{ $tienda->id }}" class="d-none">
                                                <td colspan="4">
                                                    <div class="card border-light mb-3">
                                                        <div class="card-body">
                                                            <div id="details-content-{{ $tienda->id }}">
                                                                <!-- Display Details -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <h5 class="card-title">{{ $tienda->nombre_tienda }}</h5>
                                                                        <p><strong>Dirección:</strong> {{ $tienda->direccion }}</p>
                                                                        <p><strong>Código Postal:</strong> {{ $tienda->ubigeo ? $tienda->ubigeo->codigo_postal : 'No asignado' }}</p>
                                                                        <p><strong>Ubigeo:</strong> {{ $tienda->ubigeo ? $tienda->ubigeo->departamento . ' - ' . $tienda->ubigeo->provincia . ' - ' . $tienda->ubigeo->distrito : 'No asignado' }}</p>
                                                                        <button type="button" class="btn btn-sm btn-secondary" onclick="editDetails({{ $tienda->id }})">
                                                                            <i class="fas fa-edit"></i> Editar
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-md-6 text-center">
                                                                        <div class="position-relative">
                                                                            @if($tienda->foto)
                                                                                <img id="foto-preview-{{ $tienda->id }}" src="{{ asset('storage/tiendas/' . $tienda->foto) }}" alt="{{ $tienda->nombre_tienda }}" class="img-fluid rounded shadow-sm mb-2">
                                                                                <button type="button" class="btn btn-secondary position-absolute top-0 end-0 m-2" onclick="document.getElementById('foto-input-{{ $tienda->id }}').click()">
                                                                                    <i class="fas fa-pencil-alt"></i>
                                                                                </button>
                                                                                <input type="file" id="foto-input-{{ $tienda->id }}" class="d-none" onchange="previewImage(this, {{ $tienda->id }})">
                                                                            @else
                                                                                <p class="text-muted">No disponible</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Editable Form -->
                                                            <div id="edit-content-{{ $tienda->id }}" class="d-none">
                                                                <form action="{{ route('sucursales.update', $tienda->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="row">
                                                                        <div class="col-md-6">
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
                                                                                <select class="form-select" id="id_ubigeo{{ $tienda->id }}" name="id_ubigeo" onchange="updatePostalCode(this, {{ $tienda->id }})">
                                                                                    <option value="">Seleccione</option>
                                                                                    @foreach($ubigeos as $ubigeo)
                                                                                        <option value="{{ $ubigeo->id }}" {{ $ubigeo->id == $tienda->id_ubigeo ? 'selected' : '' }}>
                                                                                            {{ $ubigeo->departamento . ' - ' . $ubigeo->provincia . ' - ' . $ubigeo->distrito }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="codigo_postal{{ $tienda->id }}" class="form-label">Código Postal</label>
                                                                                <input type="text" class="form-control" id="codigo_postal{{ $tienda->id }}" name="codigo_postal" value="{{ $tienda->ubigeo ? $tienda->ubigeo->codigo_postal : '' }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text-center">
                                                                            <div class="mb-3">
                                                                                <label for="foto{{ $tienda->id }}" class="form-label">Foto</label>
                                                                                <div class="position-relative">
                                                                                    @if($tienda->foto)
                                                                                        <img id="foto-preview-edit-{{ $tienda->id }}" src="{{ asset('storage/tiendas/' . $tienda->foto) }}" alt="{{ $tienda->nombre_tienda }}" class="img-fluid rounded shadow-sm mb-2">
                                                                                    @else
                                                                                        <p class="text-muted">No disponible</p>
                                                                                    @endif
                                                                                    <button type="button" class="btn btn-secondary position-absolute top-0 end-0 m-2" onclick="document.getElementById('foto-input-edit-{{ $tienda->id }}').click()">
                                                                                        <i class="fas fa-pencil-alt"></i>
                                                                                    </button>
                                                                                    <input type="file" class="d-none" id="foto-input-edit-{{ $tienda->id }}" name="foto" onchange="previewImage(this, {{ $tienda->id }}, 'edit')">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex gap-2">
                                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                                                                        <button type="button" class="btn btn-secondary" onclick="cancelEdit({{ $tienda->id }})"><i class="fas fa-times"></i> Cancelar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Add New Store Button -->
                                <a href="{{ route('sucursales.index') }}" class="btn btn-success mt-3">
                                    <i class="fas fa-plus"></i> Añadir Tiendas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let openDetailsId = null;

    function toggleDetails(id) {
        if (openDetailsId && openDetailsId !== id) {
            document.getElementById('details-row-' + openDetailsId).classList.add('d-none');
        }
        const detailsRow = document.getElementById('details-row-' + id);
        detailsRow.classList.toggle('d-none');
        openDetailsId = detailsRow.classList.contains('d-none') ? null : id;
    }

    function editDetails(id) {
        document.getElementById('details-content-' + id).classList.add('d-none');
        document.getElementById('edit-content-' + id).classList.remove('d-none');
    }

    function cancelEdit(id) {
        document.getElementById('details-content-' + id).classList.remove('d-none');
        document.getElementById('edit-content-' + id).classList.add('d-none');
    }

    function previewImage(input, id, type = '') {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.getElementById(type ? 'foto-preview-edit-' + id : 'foto-preview-' + id);
                imgElement.src = e.target.result;
                imgElement.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updatePostalCode(selectElement, id = null) {
        const ubigeos = @json($ubigeos);
        const selectedId = selectElement.value;
        const postalCodeInput = id ? document.getElementById('codigo_postal' + id) : document.getElementById('codigo_postal');

        if (selectedId) {
            const selectedUbigeo = ubigeos.find(ubigeo => ubigeo.id == selectedId);
            if (selectedUbigeo) {
                postalCodeInput.value = selectedUbigeo.codigo_postal;
            }
        } else {
            postalCodeInput.value = '';
        }
    }
</script>
@endsection
