<div class="modal fade" id="modalEditarRol{{ $rol->id }}" tabindex="-1" aria-labelledby="modalEditarRolLabel{{ $rol->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarRolLabel{{ $rol->id }}">Editar Rol: {{ $rol->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gestion-rol-acceso.update', $rol->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nombre_rol{{ $rol->id }}" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombre_rol{{ $rol->id }}" name="nombre"
                            value="{{ $rol->nombre }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="accesos{{ $rol->id }}" class="form-label">Accesos</label>
                        <div id="accesos{{ $rol->id }}" class="form-control" style="height: auto; padding: 0;">
                            @foreach ($accesos as $acceso)
                                <div class="form-check custom-checkbox-container">
                                    <input class="form-check-input" type="checkbox" name="id_accesos[]"
                                        value="{{ $acceso->id }}" id="acceso{{ $rol->id }}{{ $acceso->id }}"
                                        {{ in_array($acceso->id, $rol->accesos->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="acceso{{ $rol->id }}{{ $acceso->id }}">
                                        {{ $acceso->nombre }} ({{ $acceso->tipo }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Rutas --}}
