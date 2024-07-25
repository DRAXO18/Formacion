@extends('layouts.app')

@section('content')
    <br><br><br>
    <div style="margin-left: 20%;" class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Añadir Usuario</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data"
                            id="usuarioForm">
                            @csrf

                            <div class="mb-3">
                                <label for="tipoEntidad" class="form-label">Tipo de Entidad</label>
                                <select class="form-control" id="tipoEntidad" name="tipoEntidad" required>
                                    <option value="usuario">Usuario</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="proveedor">Proveedor</option>
                                </select>
                            </div>

                            <input type="hidden" id="idtipo_usuario" name="idtipo_usuario" value="">

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>

                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>

                            <div class="mb-3">
                                <label for="idtipo_documento" class="form-label">Tipo de Documento</label>
                                <select class="form-control" id="idtipo_documentoselect" name="idtipo_documentoselect"
                                    required>
                                    @foreach ($tiposDocumentos as $tipoDocumento)
                                        <option value="{{ $tipoDocumento->id }}">{{ $tipoDocumento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" id="idtipo_documento" name="idtipo_documento" value="">

                            <div class="mb-3">
                                <label for="numero_identificacion" class="form-label">Número de Identificación</label>
                                <input type="text" class="form-control" id="numero_identificacion"
                                    name="numero_identificacion" required>
                            </div>

                            <div class="mb-3 email-password-fields">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="mb-3 email-password-fields">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="mb-3 email-password-fields">
                                <label for="password-confirm" class="form-label">Confirmar Password</label>
                                <input type="password" class="form-control" id="password-confirm"
                                    name="password_confirmation">
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <img id="previewFoto" src="#" alt="Vista Previa de la Foto"
                                    style="max-width: 100%; max-height: 200px; margin-top: 10px; display: none;">
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
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
                    Usuario añadido exitosamente.
                </div>
            </div>
        </div>
    </div>
    <script>
        const fotoInput = document.getElementById('foto');
        fotoInput.addEventListener('change', previewFoto);

        function previewFoto(event) {
            const preview = document.getElementById('previewFoto');
            preview.style.display = 'block';
            preview.src = URL.createObjectURL(event.target.files[0]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tipoEntidadSelect = document.getElementById('tipoEntidad');
            const emailPasswordFields = document.querySelectorAll('.email-password-fields');
            const numeroIdentificacionInput = document.getElementById('numero_identificacion');
            const idtipoDocumentoSelect = document.getElementById('idtipo_documentoselect');
            const usuarioForm = document.getElementById('usuarioForm');

            function updateHiddenValue() {
                const selectedValue = idtipoDocumentoSelect.value;
                document.getElementById('idtipo_documento').value = selectedValue;
            }

            // Evento para actualizar el campo oculto al cambiar la selección
            idtipoDocumentoSelect.addEventListener('change', updateHiddenValue);

            // Establecer el valor inicial al cargar la página
            updateHiddenValue();

            const toggleEmailPasswordFields = (show) => {
                emailPasswordFields.forEach(field => {
                    field.style.display = show ? 'block' : 'none';
                    field.querySelector('input').required = show;
                });
            };

            const setNumeroIdentificacionAttributes = (maxLength, pattern = '') => {
                numeroIdentificacionInput.maxLength = maxLength;
                numeroIdentificacionInput.pattern = pattern;
            };

            const updateNumeroIdentificacionAttributes = () => {
                const selectedTipoDoc = idtipoDocumentoSelect.value;
                if (selectedTipoDoc === '2') { // DNI
                    setNumeroIdentificacionAttributes(8, '\\d{8}');
                } else if (selectedTipoDoc == '4') { // RUC
                    setNumeroIdentificacionAttributes(11, '\\d{11}');
                    document.getElementById('idtipo_documento').value = '4';
                } else { // Otros documentos
                    setNumeroIdentificacionAttributes(20, '\\d{20}');
                }
            };

            tipoEntidadSelect.addEventListener('change', function() {
                const selectedTipo = tipoEntidadSelect.value;

                // Limpiar el campo de número de identificación al cambiar el tipo de entidad
                numeroIdentificacionInput.value = '';

                if (selectedTipo === 'usuario') {
                    idtipo_usuario.value = '3';
                    toggleEmailPasswordFields(true);
                    idtipoDocumentoSelect.innerHTML = `
                        @foreach ($tiposDocumentos as $tipoDocumento)
                            <option value="{{ $tipoDocumento->id }}">{{ $tipoDocumento->nombre }}</option>
                        @endforeach
                    `;
                    idtipoDocumentoSelect.addEventListener('change', function() {
                        updateNumeroIdentificacionAttributes();
                    });
                    updateNumeroIdentificacionAttributes();
                } else if (selectedTipo === 'cliente') {
                    idtipo_usuario.value = '1';
                    toggleEmailPasswordFields(false);
                    idtipoDocumentoSelect.innerHTML = `
                        <option value="2">DNI</option>
                        <option value="3">Pasaporte</option>
                        <option value="1">Carnet de Extranjería</option>
                    `;
                    updateNumeroIdentificacionAttributes();
                } else if (selectedTipo === 'proveedor') {
                    idtipo_usuario.value = '2';
                    document.getElementById('idtipo_documento').value = '4';

                    toggleEmailPasswordFields(false);
                    idtipoDocumentoSelect.innerHTML = `
                        <option value="4">RUC</option>
                    `;
                    setNumeroIdentificacionAttributes(11, "\\d{11}");
                }
            });



            idtipoDocumentoSelect.addEventListener('change', updateNumeroIdentificacionAttributes);

            tipoEntidadSelect.dispatchEvent(new Event('change'));

            @if (session('success'))
                // Mostrar el toast de éxito
                var toastEl = new bootstrap.Toast(document.getElementById('successToast'));
                toastEl.show();

                // Recargar la página después de 2 segundos
                setTimeout(function() {
                    location.reload();
                }, 1000);
            @endif
        });

        const form = document.getElementById('usuarioForm');

        form.addEventListener('submit', (e) => {
            const errors = {{ json_encode($errors->all()) }}

            if (Object.keys(errors).length > 0) {
                e.preventDefault();
            }
        });

       
    </script>

@endsection
