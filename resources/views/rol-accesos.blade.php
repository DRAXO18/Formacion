@extends('layouts.app')

@section('content')
    <br><br><br><br><br>
    <div class="container mt-4" style="margin-left: 20%;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">Gestión de Roles y Accesos</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Formulario para crear nuevo rol -->
                            <div class="col-md-6 mb-4">
                                <div class="border p-4 rounded bg-light shadow-sm">
                                    <h4 class="mb-4 text-dark">Crear Nuevo Rol</h4>

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('roles.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nombreRol">Nombre del Rol</label>
                                            <input type="text" name="nombre" id="nombreRol" class="form-control"
                                                value="{{ old('nombre') }}" required>
                                            @error('nombre')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-dark">Guardar Rol</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Formulario para crear nuevo acceso -->
                            <div class="col-md-6 mb-4">
                                <div class="border p-4 rounded bg-light shadow-sm">
                                    <h4 class="mb-4 text-dark">Crear Nuevo Acceso</h4>

                                    <form action="{{ route('accesos.store') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="tipo">Tipo</label>
                                            <select name="tipo" id="tipo" class="form-control" required onchange="handleTipoChange(this)">
                                                <option value="">Seleccionar Tipo</option>
                                                <option value="acceso" {{ old('tipo') == 'acceso' ? 'selected' : '' }}>Acceso</option>
                                                <option value="subacceso" {{ old('tipo') == 'subacceso' ? 'selected' : '' }}>Subacceso</option>
                                                <option value="opcion" {{ old('tipo') == 'opcion' ? 'selected' : '' }}>Opción</option>
                                            </select>
                                            @error('tipo')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div id="subacceso-select-container" class="form-group" style="display: none;">
                                            <label for="idacceso">Acceso Padre</label>
                                            <select name="idacceso" id="idacceso" class="form-control">
                                                <option value="">Seleccionar Acceso</option>
                                                @foreach ($accesos as $acceso)
                                                <option value="{{ $acceso->id }}" {{ old('idacceso') == $acceso->id ? 'selected' : '' }}>
                                                    {{ $acceso->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('idacceso')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="nombreAcceso">Nombre del Acceso</label>
                                            <input type="text" name="nombre" id="nombreAcceso" class="form-control" value="{{ old('nombre') }}" required>
                                            @error('nombre')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="searchControlador">Buscar Controlador</label>
                                            <input type="text" id="searchControlador" class="form-control" placeholder="Buscar controlador...">
                                            <div id="controladorResults" class="list-group mt-2"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="controlador">Controlador</label>
                                            <input type="text" name="controlador" id="controlador" class="form-control" value="{{ old('controlador') }}" required>
                                            @error('controlador')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <br>
                                        <button type="submit" class="btn btn-dark">Guardar Acceso</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar la visibilidad del contenedor según el valor actual del select
            handleTipoChange(document.getElementById('tipo'));
        });

        function handleTipoChange(select) {
            // Obtener el contenedor del select idacceso
            var subaccesoSelectContainer = document.getElementById('subacceso-select-container');

            // Mostrar el contenedor solo si el valor seleccionado es 'subacceso'
            if (select.value === 'subacceso') {
                subaccesoSelectContainer.style.display = 'block';
            } else {
                subaccesoSelectContainer.style.display = 'none';
            }
        }

        document.getElementById('searchControlador').addEventListener('input', function() {
            const query = this.value;
            if (query.length > 2) {
                fetchControladores(query);
            } else {
                document.getElementById('controladorResults').innerHTML = '';
            }
        });

        function fetchControladores(query) {
            fetch(`/buscar-controladores?q=${query}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const resultsContainer = document.getElementById('controladorResults');
                    resultsContainer.innerHTML = '';
                    data.forEach(controlador => {
                        const listItem = document.createElement('a');
                        listItem.classList.add('list-group-item', 'list-group-item-action');
                        listItem.textContent = controlador;
                        listItem.addEventListener('click', () => selectControlador(controlador));
                        resultsContainer.appendChild(listItem);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        function selectControlador(controlador) {
            document.getElementById('controlador').value = controlador + '.index';
            document.getElementById('controladorResults').innerHTML = '';
        }

        function handleTipoChange(selectElement) {
            const subaccesoContainer = document.getElementById('subacceso-select-container');
            if (selectElement.value === 'subacceso') {
                subaccesoContainer.style.display = 'block';
            } else {
                subaccesoContainer.style.display = 'none';
            }
        }
    </script>
@endsection
