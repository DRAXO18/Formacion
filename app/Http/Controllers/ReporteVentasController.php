<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Marca;

class ReporteVentasController extends Controller
{
    public function index()
    {
        // Obtener todas las ventas para mostrar en el reporte inicialmente
        $ventas = Venta::latest()->paginate(10);
        
        // Obtener todas las marcas para los filtros
        $marcas = Marca::all();

        // Obtener todos los productos para los filtros
        $productos = Producto::all();

        return view('reporteventas', compact('ventas', 'marcas', 'productos'));
    }

    public function filtrar(Request $request)
    {
        // Aplicar filtros de búsqueda
        $query = Venta::query();

        if ($request->filled('marca_id')) {
            $query->whereHas('productos', function ($query) use ($request) {
                $query->where('marca_id', $request->marca_id);
            });
        }

        if ($request->filled('producto_id')) {
            $query->whereHas('productos', function ($query) use ($request) {
                $query->where('id', $request->producto_id);
            });
        }

        // Otros filtros según tus necesidades

        $ventas = $query->latest()->paginate(10);

        return response()->json($ventas);
    }

    public function buscar(Request $request)
    {
        $query = Venta::query();

        if ($request->filled('buscar')) {
            $query->where('id', $request->buscar)
                  ->orWhere('fecha_venta', 'like', '%' . $request->buscar . '%');
                  // Añadir más campos de búsqueda según tus necesidades
        }

        $ventas = $query->latest()->paginate(10);

        return response()->json($ventas);
    }

    public function ventasPorMes()
    {
        $ventasPorMes = Venta::selectRaw('MONTH(fecha_venta) as mes, SUM(total) as total')
            ->whereYear('fecha_venta', '=', 2024)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json($ventasPorMes);
    }
}
