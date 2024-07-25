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
                            <h4>Marca</h4>  
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Lexa</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Marcas</a></li>
                                <li class="breadcrumb-item active">Ingrese Marca</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Ingrese Marca</h4>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <!-- Formulario para ingresar marcas -->
                                <form action="{{ route('marca') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nombreMarca" class="form-label">Nombre de la Marca</label>
                                        <input type="text" class="form-control" id="nombreMarca" name="nombre_marca" placeholder="Nombre de la marca" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="proveedor" class="form-label">Proveedor</label>
                                        <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Nombre del proveedor" required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Agregar Marca</button>
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
