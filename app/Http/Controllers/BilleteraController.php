<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billetera;
use App\Models\Transaccion;
use Illuminate\Support\Facades\Auth;

class BilleteraController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $billetera = $user->billetera;

        // Verificar si la billetera existe; si no, crear una nueva
        if (!$billetera) {
            $billetera = Billetera::create([
                'user_id' => $user->id,
                'saldo' => 0.00
            ]);
        }

        $transacciones = $billetera->transacciones;

        return view('billetera', compact('billetera', 'transacciones'));
    }

    public function depositar(Request $request)
    {
        $user = Auth::user();
        $billetera = $user->billetera;

        if (!$billetera) {
            return redirect()->back()->with('error', 'Billetera no encontrada');
        }

        $monto = $request->input('monto');

        // Añadir transacción de depósito
        $transaccion = new Transaccion([
            'tipo' => 'deposito',
            'monto' => $monto,
            'descripcion' => 'Depósito en billetera'
        ]);
        $billetera->transacciones()->save($transaccion);

        // Actualizar saldo
        $billetera->saldo += $monto;
        $billetera->save();

        return redirect()->back()->with('success', 'Depósito realizado con éxito');
    }

    public function retirar(Request $request)
    {
        $user = Auth::user();
        $billetera = $user->billetera;

        if (!$billetera) {
            return redirect()->back()->with('error', 'Billetera no encontrada');
        }

        $monto = $request->input('monto');

        if ($billetera->saldo >= $monto) {
            // Añadir transacción de retiro
            $transaccion = new Transaccion([
                'tipo' => 'retiro',
                'monto' => $monto,
                'descripcion' => 'Retiro de billetera'
            ]);
            $billetera->transacciones()->save($transaccion);

            // Actualizar saldo
            $billetera->saldo -= $monto;
            $billetera->save();

            return redirect()->back()->with('success', 'Retiro realizado con éxito');
        }

        return redirect()->back()->with('error', 'Saldo insuficiente');
    }
}
