<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Muestra todas las marcas o las marcas filtradas por búsqueda.
     */

    //  public function __construct()
    // {
    //     $this->middleware('checkAcceso:Crear Marca')->only('store');
    // }

    public function index(Request $request)
    {
        // Obtener todos los parámetros de búsqueda del request
        $search = $request->input('search');

        // Iniciar la consulta para obtener las marcas
        $query = Marca::select('id', 'nombre_marca', 'proveedor');

        // Aplicar filtro de búsqueda si existe
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre_marca', 'like', '%' . $search . '%')
                    ->orWhere('proveedor', 'like', '%' . $search . '%');
            });
        }

        // Obtener las marcas según los filtros aplicados
        $marcas = $query->get();

        // Devolver la vista parcial si es una solicitud AJAX
        if ($request->ajax()) {
            return view('partials.marcas-table', compact('marcas'));
        }

        // Devolver la vista completa con las marcas y el parámetro de búsqueda
        return view('visualizarmarca', compact('marcas', 'search'));
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

    public function show($id)
{
    $marca = Marca::find($id);

    if ($marca) {
        return response()->json($marca);
    }

    return response()->json(['error' => 'Marca no encontrada'], 404);
}
public function update(Request $request, $id)
{
    $request->validate([
        'nombre_marca' => 'required|string|max:255',
        'proveedor' => 'required|string|max:255',
    ]);

    $marca = Marca::find($id);

    if ($marca) {
        $marca->update([
            'nombre_marca' => $request->nombre_marca,
            'proveedor' => $request->proveedor,
        ]);

        return response()->json(['success' => 'Marca actualizada exitosamente']);
    }

    return response()->json(['error' => 'Marca no encontrada'], 404);
}
}
