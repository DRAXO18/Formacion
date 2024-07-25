<?php

namespace App\Http\Controllers;

use App\Models\AsignarRol;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;

class AsignarRolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener usuarios de tipo 3
        $usuarios = User::where('idtipo_usuario', 3)->get();

        // Obtener roles
        $roles = Rol::all();

        return view('asignarrol', compact('usuarios', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'id_rol' => 'required|exists:roles,id',
        ]);

        // Asignar el rol al usuario
        AsignarRol::create([
            'id_usuario' => $request->id_usuario,
            'id_rol' => $request->id_rol,
            'nombre' => User::find($request->id_usuario)->nombre,
            'correo' => User::find($request->id_usuario)->email,
        ]);

        // Actualizar el campo id_rol en la tabla users
        User::where('id', $request->id_usuario)->update(['id_rol' => $request->id_rol]);

        return redirect()->route('asignar-rol.index')->with('success', 'Rol asignado exitosamente.');
    }

    
}
