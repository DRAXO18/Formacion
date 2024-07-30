<?php

namespace App\Http\Controllers;

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

    public function buscarUsuarios(Request $request)
{
    $query = $request->input('query');

    // Buscar usuarios de tipo 3 que coincidan con la búsqueda por nombre, apellido, email o número de identificación
    $usuarios = User::where('idtipo_usuario', 3)
                    ->where(function($q) use ($query) {
                        $q->where('nombre', 'LIKE', "%{$query}%")
                          ->orWhere('apellido', 'LIKE', "%{$query}%")
                          ->orWhere('email', 'LIKE', "%{$query}%")
                          ->orWhere('numero_identificacion', 'LIKE', "%{$query}%");
                    })
                    ->get();

    return response()->json($usuarios);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'id_rol' => 'required|exists:roles,id',
        ]);

        // Actualizar el campo id_rol en la tabla users para el usuario seleccionado
        User::where('id', $request->id_usuario)->update(['id_rol' => $request->id_rol]);

        return redirect()->route('asignar-rol.index')->with('success', 'Rol asignado exitosamente.');
    }
}
