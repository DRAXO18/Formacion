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
                            <h4>Agregar Cliente</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('agregar') }}">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Añadirusuario') }}">Clientes</a></li>
                                <li class="breadcrumb-item active">Agregar Cliente</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Ingrese Cliente</h4>
                                <!-- Formulario para ingresar clientes -->
                                <form method="POST" action="{{ route('clientes.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                                        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                                            placeholder="Nombre del Cliente" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido_cliente" class="form-label">Apellido del Cliente</label>
                                        <input type="text" class="form-control" id="apellido_cliente" name="apellido_cliente"
                                            placeholder="Apellido del Cliente" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombre_empresa" class="form-label">Nombre de la Empresa</label>
                                        <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa"
                                            placeholder="Nombre de la Empresa" required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Agregar Cliente</button>
                                    </div>
                                </form>
                                <!-- Fin del formulario de ingreso -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
