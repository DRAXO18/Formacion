<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tienda;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\Storage;

class TiendaController extends Controller
{
    // Mostrar la vista para agregar nuevas tiendas
    public function index()
    {
        $ubigeos = Ubigeo::all();
        
        return view('sucursales', compact('ubigeos'));
    }

    
    
    public function vistasucursales()
    {
        // Ajusta el método para paginar resultados
        $tiendas = Tienda::with('ubigeo')->paginate(10); // Cambia el número 10 por el número de resultados por página que desees
        $ubigeos = Ubigeo::all();
        return view('versucursales', compact('ubigeos', 'tiendas'));
    }

    // Guardar una nueva tienda
    public function store(Request $request)
    {
        $request->validate([
            'nombre_tienda' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'id_ubigeo' => 'nullable|exists:ubigeo,id', // Asegúrate de que el nombre del campo coincida con el de tu base de datos
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('public/tiendas');
            $data['foto'] = basename($imagePath);
        }

        Tienda::create($data);

        return redirect()->route('sucursales.index')->with('success', 'Tienda agregada exitosamente.');
    }

    // Actualizar una tienda
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_tienda' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'id_ubigeo' => 'nullable|exists:ubigeos,id', // Asegúrate de que el nombre del campo coincida con el de tu base de datos
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

        return redirect()->route('versucursales')->with('success', 'Tienda actualizada exitosamente.');
    }

    // Eliminar una tienda
    public function destroy($id)
    {
        $tienda = Tienda::findOrFail($id);

        // Eliminar la imagen si existe
        if ($tienda->foto && Storage::exists('public/tiendas/' . $tienda->foto)) {
            Storage::delete('public/tiendas/' . $tienda->foto);
        }

        $tienda->delete();

        return redirect()->route('versucursales')->with('success', 'Tienda eliminada exitosamente.');
    }

    // Obtener información del ubigeo
    public function getUbigeo($id)
    {
        $ubigeo = Ubigeo::find($id);
        return response()->json($ubigeo);
    }
}
