<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetallesVenta;
use App\Models\User;
use App\Models\Cliente;

class HistorialController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente', 'usuario')->get();
        return view('historial.index', compact('ventas'));
    }

    public function detalles($id)
    {
        try {
            $detalles = DetallesVenta::with('producto.marca')
            ->where('id_venta', $id)
            ->with('producto.marca')
            ->get();
            return response()->json($detalles);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filtrar(Request $request)
    {
        $query = Venta::with('cliente', 'usuario');

        // Filtro por más recientes o más antiguas
    if ($request->orden_fecha == 'recientes') {
        $query->orderByDesc('fecha_venta');
    } elseif ($request->orden_fecha == 'antiguas') {
        $query->orderBy('fecha_venta');
    }

        // Filtro por ID de venta
        if ($request->id_venta) {
            $query->where('id', $request->id_venta);
        }

        // Filtro por nombre de usuario
        if ($request->nombre_usuario) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre_usuario . '%')
                  ->orWhere('apellido', 'like', '%' . $request->nombre_usuario . '%');
            });
        }

        // Obtener ventas filtradas
        $ventas = $query->get();

        return view('historial.index', compact('ventas'));
    }
}
