<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\USer;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Obtener el producto más vendido
         $productoMasVendido = Producto::orderByDesc('cantidad_vendida')->first();

         // Obtener el total de ventas realizadas
         $ventasRealizadas = Venta::count();
 
         // Obtener el número de usuarios activos (clientes que compran)
         $clientesQueCompran = User::whereHas('ventas')->count();
 
         return view('dashboard.index', [
            'productoMasVendido' => $productoMasVendido,
            'ventasRealizadas' => $ventasRealizadas,
            'clientesQueCompran' => $clientesQueCompran,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
