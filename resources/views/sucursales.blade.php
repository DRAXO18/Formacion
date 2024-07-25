@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Agregar Nueva Tienda</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Inicios</a></li>
                                <li class="breadcrumb-item"><a href="#">Sucursales</a></li>
                                <li class="breadcrumb-item active">Agregar Tienda</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-light">
                            <div class="card-body">
                                <h4 class="header-title">Formulario para Agregar Tienda</h4>
                                <form action="{{ route('sucursales.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nombre_tienda" class="form-label">Nombre de la Tienda</label>
                                        <input type="text" class="form-control" id="nombre_tienda" name="nombre_tienda" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_ubigeo" class="form-label">Ubigeo</label>
                                        <select class="form-select" id="id_ubigeo" name="id_ubigeo" required>
                                            <option value="" selected disabled>Seleccione un Ubigeo</option>
                                            @foreach ($ubigeos as $ubigeo)
                                                <option value="{{ $ubigeo->id }}">{{ $ubigeo->departamento }} - {{ $ubigeo->distrito }} - {{ $ubigeo->provincia }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codigo_postal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                        <div class="mt-2" id="fotoPreview">
                                            <!-- Preview Image will be displayed here -->
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Agregar Tienda</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('id_ubigeo').addEventListener('change', function () {
        var ubigeoId = this.value;
        if (ubigeoId) {
            fetch('/ubigeo/' + ubigeoId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('codigo_postal').value = data.codigo_postal;
                })
                .catch(error => console.error('Error:', error));
        } else {
            document.getElementById('codigo_postal').value = '';
        }
    });

    document.getElementById('foto').addEventListener('change', function (event) {
        var file = event.target.files[0];
        var preview = document.getElementById('fotoPreview');
        preview.innerHTML = ''; // Clear previous preview
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-fluid';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
