<?php

namespace App\Http\Controllers;
// use App\Models\Notification;

use App\Models\Compra;
use App\Models\Stock;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\User;
use App\Models\TipoVenta;
use Illuminate\Http\Request;
use App\Models\TipoCompra;
use Illuminate\Support\Facades\Auth;

class RealizarCompraController extends Controller
{
    public function index()
    {
        $tipos_venta = TipoVenta::all(); // Obtener todos los tipos de venta

        return view('realizacompras', [
            'tipos_venta' => $tipos_venta
        ]);
    }

    public function buscarProveedores(Request $request)
    {
        $search = $request->get('search');

        $proveedores = User::where('idtipo_usuario', 2)
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('apellido', 'like', '%' . $search . '%')
                    ->orWhere('numero_identificacion', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json($proveedores);
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

    public function guardarCompra(Request $request)
    {
        // Validación de datos
        $request->validate([
            'proveedor_id' => 'required|exists:users,id',
            'fecha_compra' => 'required|date',
            'tipo_compra' => 'required|exists:tipo_venta,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        // Obtener productos desde el formulario
        $productos = $request->input('productos');

        // Calcular el total de la compra
        $totalCompra = 0;
        foreach ($productos as $producto) {
            $totalCompra += $producto['precio'] * $producto['cantidad'];
        }

        // Crear la compra
        $compra = Compra::create([
            'proveedor_id' => $request->proveedor_id,
            'fecha_compra' => $request->fecha_compra,
            'id_tipo_compra' => $request->tipo_compra,
            'id_usuario' => Auth::id(),
            'total' => $totalCompra,
        ]);

        // Guardar detalles de la compra (productos)
        foreach ($productos as $producto) {
            DetalleCompra::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'subtotal' => $producto['precio'] * $producto['cantidad'],
            ]);

            Stock::create([
                'idProducto' => $producto['id'],
                'tipo_movimiento' => 'entrada',
                'cantidad' => $producto['cantidad'],
            ]);

            // Actualizar el stock del producto
            $productoModel = Producto::find($producto['id']);
            $productoModel->stock += $producto['cantidad'];
            $productoModel->save();
        }

        // Notification::create([
        //     'user_id' => auth()->user()->id,
        //     'message' => 'Se realizó una venta.',
        //     'type' => 'venta'
        // ]);

        return response()->json(['success' => 'Compra registrada correctamente']);
    }

    public function detallesCompra($idCompra)
    {
        $detallesCompra = DetalleCompra::where('compra_id', $idCompra)->get();

        foreach ($detallesCompra as $detalle) {
            $producto = Producto::find($detalle->producto_id);

            // Añadir nombre de la marca y precio del producto al detalle
            $detalle->nombre_marca = $producto->marca->nombre; // Nombre de la marca del producto
            $detalle->precio_unitario = $producto->precio; // Precio unitario del producto
        }

        return response()->json($detallesCompra);
    }
}
