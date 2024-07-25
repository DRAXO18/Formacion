<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('marca')->get();
        $marcas = Marca::all();

        return view('producto', compact('productos', 'marcas'));
    }

    public function create()
    {
        $marcas = Marca::all();
        return view('producto', compact('marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50',
            'idMarca' => 'required|exists:marcas,id',
            'precio' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->codigo = $request->codigo;
        $producto->idMarca = $request->idMarca;
        $producto->precio = $request->precio;

        if ($request->hasFile('foto')) {
            $imagen = $request->file('foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = 'productos/' . $nombreImagen;

            // Almacenar la imagen en el almacenamiento
            $imagen->storeAs('public/' . $rutaImagen);

            // Guardar la ruta de la imagen en el modelo Producto
            $producto->foto = $rutaImagen;
        }

        $producto->save();

        return redirect()->route('producto')->with('success', 'Producto agregado correctamente');
    }

    public function show(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $marcas = Marca::all();

        return view('producto', compact('producto', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50',
            'idMarca' => 'required|exists:marcas,id',
            'precio' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->codigo = $request->codigo;
        $producto->idMarca = $request->idMarca;
        $producto->precio = $request->precio;

        if ($request->hasFile('foto')) {
            // Eliminar la imagen anterior si existe
            if ($producto->foto) {
                Storage::delete('public/' . $producto->foto);
            }

            // Procesar y almacenar la nueva imagen
            $imagen = $request->file('foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = 'productos/' . $nombreImagen;

            // Almacenar la imagen en el almacenamiento
            $imagen->storeAs('public/' . $rutaImagen);

            // Guardar la ruta de la nueva imagen en el modelo Producto
            $producto->foto = $rutaImagen;
        }

        $producto->save();

        return redirect()->route('producto')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar la imagen asociada si existe
        if ($producto->foto) {
            Storage::delete('public/' . $producto->foto);
        }

        $producto->delete();

        return redirect()->route('producto')->with('success', 'Producto eliminado correctamente');
    }
}
