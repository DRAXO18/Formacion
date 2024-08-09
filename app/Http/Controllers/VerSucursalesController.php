<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tienda;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\Storage;

class VerSucursalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ajusta el método para paginar resultados
        $tiendas = Tienda::with('ubigeo')->paginate(10); // Cambia el número 10 por el número de resultados por página que desees
        $ubigeos = Ubigeo::all();
        return view('versucursales', compact('ubigeos', 'tiendas'));
    }

    public function vistasucursales()
    {
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     // Actualizar una tienda
     public function update(Request $request, $id)
     {
         $request->validate([
             'nombre_tienda' => 'required|string|max:255',
             'direccion' => 'required|string|max:255',
             'id_ubigeo' => 'nullable|exists:ubigeo,id', // Asegúrate de que el nombre del campo coincida con el de tu base de datos
             'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
         ]);
 
         $tienda = Tienda::findOrFail($id);
         $data = $request->all();
 
         if ($request->hasFile('foto')) {
             // Eliminar la imagen anterior si existe
             if ($tienda->foto && Storage::exists('public/tiendas/' . $tienda->foto)) {
                 Storage::delete('public/tiendas/' . $tienda->foto);
             }
 
             $imagePath = $request->file('foto')->store('public/tiendas');
             $data['foto'] = basename($imagePath);
         }
 
         $tienda->update($data);
 
         return redirect()->route('VerSucursalesController.index')->with('success', 'Tienda actualizada exitosamente.');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tienda = Tienda::findOrFail($id);

        // Eliminar la imagen si existe
        if ($tienda->foto && Storage::exists('public/tiendas/' . $tienda->foto)) {
            Storage::delete('public/tiendas/' . $tienda->foto);
        }

        $tienda->delete();

        return redirect()->route('VerSucursalesController.index')->with('success', 'Tienda eliminada exitosamente.');
    }

    public function getUbigeo($id)
    {
        $ubigeo = Ubigeo::find($id);
        return response()->json($ubigeo);
    }
}
