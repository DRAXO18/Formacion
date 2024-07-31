<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Acceso;
use Illuminate\Http\Request;

class RolAccesoController extends Controller
{
    public function index()
    {
        $accesos = Acceso::where('tipo', 'acceso')->get();
        return view('rol-accesos', compact('accesos'));
    }

    public function create()
    {
        $accesos = Acceso::where('tipo', 'acceso')->get();
        return view('rol-accesos', compact('accesos'));
    }

    public function storeRol(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Rol::create([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->route('roles.create')->with('success', 'Rol creado con éxito.');
    }

    public function storeRolModal(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Rol::create([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Rol creado con éxito.');
    }

    public function storeAcceso(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'controlador' => 'required|string|max:255',
        'tipo' => 'required|string',
        'idacceso' => 'nullable|integer|in:0,' . implode(',', Acceso::pluck('id')->toArray()),
    ]);

    // Preparar los datos para la creación
    $data = $request->only(['nombre', 'controlador', 'tipo']);

    // Incluir idacceso si el tipo es subacceso
    if ($request->input('tipo') == 'subacceso') {
        $data['idacceso'] = $request->input('idacceso', 0);
    } else {
        // Asegúrate de que idacceso esté presente pero como NULL si no es subacceso
        $data['idacceso'] = 0;
    }

    // Crear el nuevo acceso
    Acceso::create($data);

    // Redirigir con un mensaje de éxito
    return redirect()->route('roles.create')->with('success', 'Acceso creado con éxito.');
}

}