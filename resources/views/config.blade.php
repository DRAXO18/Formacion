<!-- resources/views/config.blade.php -->
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
                        <div class="card-header  text-dark d-flex align-items-center">
                    <i class="fas fa-cogs fa-2x me-2"></i>
                    <h3 class="mb-0">Configuración</h3>
                </div>
                            
                        </div>
                    </div>
                </div>
            <!-- <div class="card shadow-lg border-light rounded">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-cogs fa-2x me-2"></i>
                    <h3 class="mb-0">Configuración</h3>
                </div> -->
                <div class="card-body">
                    <!-- Mensaje de estado -->
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Información del Usuario -->
                    <div class="mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('default-avatar.png') }}" class="img-fluid rounded-circle border border-3 border-primary" alt="Foto del Usuario" style="width: 150px; height: 150px;">
                            </div>
                            <div class="col-md-8">
                                <h4 class="mb-2">{{ $user->nombre }} {{ $user->apellido }}</h4>
                                <p class="mb-2"><i class="fas fa-envelope"></i> <strong>Email:</strong> {{ $user->email }}
                                    @if (!$user->hasVerifiedEmail())
                                        <form action="{{ route('configuracion.verify-email') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm ms-2">
                                                <i class="fas fa-check-circle"></i> Verificar Email
                                            </button>
                                        </form>
                                    @endif
                                </p>
                                <p class="mb-2"><i class="fas fa-id-card"></i> <strong>Identificación:</strong> {{ $user->numero_identificacion }}</p>
                                <p class="mb-2"><i class="fas fa-file-alt"></i> <strong>Tipo de Documento:</strong> {{ $user->tipoDocumento->nombre ?? 'N/A' }}</p>
                                <p class="mb-2"><i class="fas fa-user-tag"></i> <strong>Tipo de Usuario:</strong> {{ $user->tipoUsuario->nombre ?? 'N/A' }}</p>
                                <p class="mb-2"><i class="fas fa-shield-alt"></i> <strong>Rol:</strong> {{ $user->rol->nombre ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Cambio de Contraseña -->
                    <form method="POST" action="{{ route('configuracion.update-password') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label"><i class="fas fa-lock"></i> Contraseña Actual</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label"><i class="fas fa-key"></i> Nueva Contraseña</label>
                            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                            @error('new_password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="new_password_confirmation" class="form-label"><i class="fas fa-key"></i> Confirmar Nueva Contraseña</label>
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush
