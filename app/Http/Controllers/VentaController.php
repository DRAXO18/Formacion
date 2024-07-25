<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetallesVenta;
use App\Models\TipoVenta;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function create()
    {
        $tipos_venta = TipoVenta::all();
        return view('ventas.crearVenta', compact('tipos_venta'));
    }

    public function buscarClientes(Request $request)
    {
        $search = $request->input('search');
        $clientes = Cliente::where('nombre_cliente', 'like', "%$search%")
            ->orWhere('apellido_cliente', 'like', "%$search%")
            ->orWhere('nombre_empresa', 'like', "%$search%")
            ->get();

        return response()->json($clientes);
    }

    public function buscarProductos(Request $request)
    {
        $search = $request->get('search');
    $productos = Producto::where('nombre', 'like', '%' . $search . '%')->get();
    $productosArray = $productos->map(function ($producto) {
        return [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
        ];
    })->all();
    return response()->json(['productos' => $productosArray]);
    }

    public function guardarVenta(Request $request)
    {
        // Validación de datos
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_registro' => 'required|date',
            'tipo_venta' => 'required|exists:tipos_venta,id',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio' => 'required|numeric|min:0',
        ]);

        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'fecha_registro' => $request->fecha_registro,
            'id_tipo_venta' => $request->tipo_venta,
            'id_usuario' => Auth::id(),  // Registrar el ID del usuario logueado
        ]);

        // Obtener los detalles de venta del formulario
        $detalles = $request->detalles;

        foreach ($detalles as $detalle) {
            // Crear el detalle de la venta
            DetallesVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $detalle['producto_id'],
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio'],
                'subtotal' => $detalle['cantidad'] * $detalle['precio'],
            ]);

            // Actualizar el precio del producto
            $producto = Producto::find($detalle['producto_id']);
            $producto->precio = $detalle['precio'];
            $producto->save();
        }

        return response()->json(['message' => 'Venta realizada correctamente'], 200);
    }
}
