@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

<div class="container mt-5">
    <h1 class="text-center">Mi Billetera Digital</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2>Saldo: S/ {{ number_format($billetera->saldo, 2) }}</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDeposito">Depositar</button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRetiro">Retirar</button>
        </div>
    </div>

    <h2>Historial de Transacciones</h2>
    <ul class="list-group">
        @foreach ($transacciones as $transaccion)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $transaccion->descripcion }}</span>
                <span>{{ $transaccion->tipo }}: S/ {{ number_format($transaccion->monto, 2) }}</span>
            </li>
        @endforeach
    </ul>
</div>

<!-- Modal para Depósito -->
<div class="modal fade" id="modalDeposito" tabindex="-1" aria-labelledby="modalDepositoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('billetera.depositar') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDepositoLabel">Depositar Dinero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" step="0.01" name="monto" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Depositar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Retiro -->
<div class="modal fade" id="modalRetiro" tabindex="-1" aria-labelledby="modalRetiroLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('billetera.retirar') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRetiroLabel">Retirar Dinero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" step="0.01" name="monto" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Retirar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
