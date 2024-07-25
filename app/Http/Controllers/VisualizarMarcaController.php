<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class VisualizarMarcaController extends Controller
{
    /**
     * Muestra todas las marcas.
     */
    public function index()
    {
        $marcas = Marca::all(['id', 'nombre_marca', 'proveedor']);
        return view('visualizarmarca', compact('marcas'));
    }

    /**
     * Muestra el formulario para crear una nueva marca.
     */
    public function create()
    {
        return view('marca');
    }

    /**
     * Almacena una nueva marca en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_marca' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
        ]);

        Marca::create([
            'nombre_marca' => $request->nombre_marca,
            'proveedor' => $request->proveedor,
        ]);

        return redirect()->back()->with('success', 'Marca agregada exitosamente');
    }

    /**
     * Actualiza la marca especificada en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_marca' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
        ]);

        $marca = Marca::findOrFail($id);
        $marca->nombre_marca = $request->nombre_marca;
        $marca->proveedor = $request->proveedor;
        $marca->save();

        return response()->json(['success' => 'Marca actualizada correctamente.']);
    }
}
