<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\Acceso;
use App\Models\PermisoAcceso;

class GestionRolAccesoController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        $accesos = Acceso::all();
        return view('gestion-rol-acceso', compact('roles', 'accesos'));
    }

    public function create()
    {
        $roles = Rol::all();
        $accesos = Acceso::all();
        return view('gestion-rol-acceso', compact('roles', 'accesos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
            'id_accesos' => 'required|array',
            'id_accesos.*' => 'exists:accesos,id',
        ]);
    
        // Encuentra el rol seleccionado
        $rol = Rol::findOrFail($request->id_rol);
    
        // Limpia los accesos existentes para este rol (opcional)
        $rol->accesos()->sync([]);
    
        // Inserta los accesos seleccionados
        $rol->accesos()->sync($request->id_accesos);
    
        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Accesos y Roles gestionados correctamente.');
    }
}
