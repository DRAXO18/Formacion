<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Acceso;
use Illuminate\Http\Request;

class RolAccesoController extends Controller
{
    public function index()
    {
        return view('rol-accesos');
    }
    // Mostrar el formulario para crear un nuevo rol y acceso
    public function create()
    {
        return view('rol-accesos');
    }

    // Almacenar un nuevo rol
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

    // Almacenar un nuevo acceso
    public function storeAcceso(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'controlador' => 'required|string|max:255',
            'tipo' => 'required|in:acceso,subacceso,opcion',
        ]);

        Acceso::create([
            'nombre' => $request->input('nombre'),
            'controlador' => $request->input('controlador'),
            'tipo' => $request->input('tipo'),
        ]);

        return redirect()->route('roles.create')->with('success', 'Acceso creado con éxito.');
    }

    // Almacenar un nuevo acceso
    public function storeAccesoModal(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'controlador' => 'required|string|max:255',
            'tipo' => 'required|in:acceso,subacceso,opcion',
        ]);

        Acceso::create([
            'nombre' => $request->input('nombre'),
            'controlador' => $request->input('controlador'),
            'tipo' => $request->input('tipo'),
        ]);

        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Acceso creado con éxito.');
    }
}
