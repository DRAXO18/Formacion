<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Producto;

class AgregarController extends Controller
{
    /**
     * Muestra el formulario para agregar un producto.
     */
    public function index()
    {
        $marcas = Marca::all();
        return view('agregar', compact('marcas'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos del formulario
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string',
            'idMarca' => 'required|exists:marcas,id', // Debes asegurarte de que coincida con el nombre de campo en tu formulario
            'precio' => 'required|numeric',
            'id_responsable' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear un nuevo producto en la base de datos
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->codigo = $request->codigo;
        $producto->idMarca = $request->idMarca; // Asegúrate de que coincida con el nombre real de la columna en tu tabla de productos
        $producto->precio = $request->precio;
        $producto->id_responsable = $request->id_responsable; 
        $producto->save();

        // Redirigir a la vista de lista de productos o a donde corresponda
        return redirect()->route('producto.index')->with('success', 'Producto agregado correctamente');
    }
}



