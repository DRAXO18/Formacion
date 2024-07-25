<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Notification;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Stock;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetallesVenta;
use App\Models\TipoVenta;
use Illuminate\Support\Facades\Auth;

class RealizaventaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos_venta = TipoVenta::all();

        return view('realizaventas', compact('tipos_venta'));
    }

    public function buscarUsuarios(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('idtipo_usuario', 1)
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', "%$search%")
                    ->orWhere('apellido', 'LIKE', "%$search%")
                    ->orWhere('numero_identificacion', 'LIKE', "%$search%");
            })
            ->get();

        return response()->json($users);
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
            'cliente_id' => 'required|exists:users,id',
            'fecha_venta' => 'required|date',
            'tipo_venta' => 'required|exists:tipo_venta,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        // Obtener productos desde el formulario
        $productos = $request->input('productos');

        // Calcular el total de la venta
        $totalVenta = 0;
        foreach ($productos as $producto) {
            $totalVenta += $producto['precio'] * $producto['cantidad'];
        }

        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'fecha_venta' => $request->fecha_venta,
            'id_tipo_venta' => $request->tipo_venta,
            'id_usuario' => Auth::id(),
            'total' => $totalVenta,
        ]);

        // Guardar detalles de la venta (productos)
        foreach ($productos as $producto) {

            $productoModel = Producto::find($producto['id']);
            $productoModel->precio = $producto['precio'];
            $productoModel->save();

            DetallesVenta::create([
                'id_venta' => $venta->id,
                'id_producto' => $producto['id'],
                'precio_unitario' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
                'subtotal' => $producto['precio'] * $producto['cantidad'],
            ]);

            // Registrar el movimiento de salida en el stock
            Stock::create([
                'idProducto' => $producto['id'],
                'tipo_movimiento' => 'salida',
                'cantidad' => $producto['cantidad'],
            ]);

            // Actualizar el stock del producto
            $productoModel = Producto::find($producto['id']);
            $productoModel->stock -= $producto['cantidad'];
            $productoModel->save();
        }

        // Notification::create([
        //     'user_id' => auth()->user()->id,
        //     'message' => 'Se realizó una venta.',
        //     'type' => 'venta'
        // ]);

        return response()->json(['success' => 'Venta registrada correctamente']);
    }

    public function detallesVenta($idVenta)
    {
        $detallesVenta = DetallesVenta::where('id_venta', $idVenta)->get();

        foreach ($detallesVenta as $detalle) {
            $producto = Producto::find($detalle->id_producto);

            // Añadir nombre de la marca y precio del producto al detalle
            $detalle->nombre_marca = $producto->marca->nombre; // Nombre de la marca del producto
            $detalle->precio_unitario = $producto->precio; // Precio unitario del producto
        }

        return response()->json($detallesVenta);
    }
}
