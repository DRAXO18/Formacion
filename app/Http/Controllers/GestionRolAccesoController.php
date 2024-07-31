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
        $roles = Rol::with('accesos')->get();
        $accesos = Acceso::all();
        $accesos = Acceso::where('tipo', 'acceso')->get();
        return view('gestion-rol-acceso', compact('roles', 'accesos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
            'id_accesos' => 'required|array',
            'id_accesos.*' => 'exists:accesos,id',
        ]);

        $rol = Rol::findOrFail($request->id_rol);
        $rol->accesos()->sync($request->id_accesos);

        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Accesos y Roles gestionados correctamente.');
    }

    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        $accesos = Acceso::all();
        return view('editar-rol', compact('rol', 'accesos'));
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->nombre = $request->input('nombre');
        $rol->save();

        // Sincronizar accesos
        $rol->accesos()->sync($request->input('id_accesos', []));

        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Rol actualizado con éxito.');
    }


    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return redirect()->route('gestion-rol-acceso.index')->with('success', 'Rol eliminado correctamente.');
    }
}
