@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Ingrese Producto</h4>
                                        <button id="favorite-btn" class="btn">
                                            <i class="fa fa-star" id="favorite-icon"></i> 
                                        </button>
                                        <!-- Formulario para ingresar productos -->
                                        <form id="productForm" action="{{ route('productos.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre"
                                                    required>
                                            </div>
                                            <input type="hidden" class="form-control" id="nid_responsable" name="id_responsable" value="{{ Auth::user()->id }}">


                                            <div class="mb-3">
                                                <label for="codigo" class="form-label">Código</label>
                                                <input type="text" class="form-control" id="codigo" name="codigo"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="idMarca" class="form-label">Marca</label>
                                                <select class="form-select" id="idMarca" name="idMarca" required>
                                                    <option value="" disabled selected>---SELECCIONE---</option>
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre_marca }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="precio" class="form-label">Precio</label>
                                                <input type="number" step="0.01" class="form-control" id="precio"
                                                    name="precio" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Foto del Producto</label>
                                                <input type="file" class="form-control" id="foto" name="foto"
                                                    accept="image/*" onchange="resizeImage(event)">
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Agregar Producto</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="resetForm()">Limpiar</button>
                                            </div>
                                        </form>
                                        <!-- Fin del formulario de ingreso -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Imagen Previa</h4>
                                        <div class="mb-3 text-center">
                                            <img src="{{ asset('storage/productos/default.jpg') }}" id="imagen_previa"
                                                class="img-fluid img-thumbnail" onmouseover="zoomIn()"
                                                onmouseout="zoomOut()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Script para mostrar imagen previa y funciones adicionales -->
    <script>

        document.getElementById('favorite-btn').addEventListener('click', function() {
        const params = new URLSearchParams(window.location.search).toString();
        
        fetch('{{ route("favorites.toggle") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                view_name: '{{ Route::currentRouteName() }}',
                view_params: params
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                document.getElementById('favorite-icon').classList.add('text-warning');
            } else {
                document.getElementById('favorite-icon').classList.remove('text-warning');
            }
        });
    });



        // Función para redimensionar y previsualizar la imagen seleccionada
        function resizeImage(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var max_width = 300;
                    var max_height = 300;
                    var width = img.width;
                    var height = img.height;

                    if (width > height) {
                        if (width > max_width) {
                            height *= max_width / width;
                            width = max_width;
                        }
                    } else {
                        if (height > max_height) {
                            width *= max_height / height;
                            height = max_height;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);

                    document.getElementById('imagen_previa').src = canvas.toDataURL('image/jpeg');
                }
                img.src = reader.result;
            }
            reader.readAsDataURL(file);
        }

        // Función para hacer zoom en la imagen
        function zoomIn() {
            var image = document.getElementById('imagen_previa');
            image.style.transform = 'scale(1.3)'; // Aumenta el tamaño al 130%
            image.style.transition = 'transform 0.3s ease'; // Añade una transición suave
        }

        // Función para restaurar el tamaño original de la imagen
        function zoomOut() {
            var image = document.getElementById('imagen_previa');
            image.style.transform = 'scale(1)'; // Restaura el tamaño original
        }

        // Función para limpiar el formulario y recargar la página
        function resetForm() {
            document.getElementById('productForm').reset(); // Resetea los campos del formulario
            document.getElementById('imagen_previa').src = '{{ asset('storage/productos/default.jpg') }}'; // Restaura la imagen por defecto
        }

        // Limpiar el formulario después de enviarlo
        document.getElementById('productForm').onsubmit = function() {
            setTimeout(function() {
                document.getElementById('productForm').reset();
                document.getElementById('imagen_previa').src = '{{ asset('storage/productos/default.jpg') }}';
            }, 500); // Esperar 0.5 segundos antes de limpiar el formulario

        };
    </script>
@endsection
