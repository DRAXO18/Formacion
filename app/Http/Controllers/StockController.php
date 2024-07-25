<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $brands = \App\Models\Marca::all(); // Asume que tienes un modelo Marca
        $productos = Producto::with('marca')->get();
        return view('operacionesstock', compact('brands','productos'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $brandId = $request->get('brand_id');
        
        $productos = Producto::with('marca')
                        ->where('nombre', 'LIKE', "%{$query}%")
                        ->when($brandId, function($query) use ($brandId) {
                            return $query->where('idMarca', $brandId);
                        })
                        ->get();

        return response()->json($productos);
    }

    public function update(Request $request)
    {
        $data = $request->input('data');    

        foreach ($data as $item) {
            $stock = new Stock();
            $stock->idProducto = $item['idProducto'];
            $stock->tipo_movimiento = $item['tipo_movimiento'];
            $stock->cantidad = $item['cantidad'];
            $stock->save();

            // Actualizar el stock del producto
            $producto = Producto::find($item['idProducto']);
            if ($item['tipo_movimiento'] === 'entrada') {
                $producto->stock += $item['cantidad'];
            } elseif ($item['tipo_movimiento'] === 'salida') {
                $producto->stock -= $item['cantidad'];
            }
            $producto->save();
        }

        return response()->json(['success' => true]);
    }
}

