<?php

namespace App\Http\Controllers;

use App\Models\TipoDocumento;
use App\Models\User;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UsuariosController extends Controller
{
    public function index()
    {
        $tiposUsuarios = TipoUsuario::all();
        $tiposDocumentos = TipoDocumento::all();
        $usuarios = User::all();
        
        return view('agregar-usuario', compact('usuarios', 'tiposUsuarios', 'tiposDocumentos'));
    }

    public function create()
    {
        $tiposUsuarios = TipoUsuario::all();
        $tiposDocumentos = TipoDocumento::all();
        
        return view('agregar-usuario', compact('tiposUsuarios', 'tiposDocumentos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'apellido' => 'required',
                'numero_identificacion' => 'required',
                'idtipo_usuario' => 'required|exists:tipos_usuarios,id',
                'idtipo_documento' => 'required|exists:tipo_documento,id',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'nullable|confirmed',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tamaño máximo 2MB
            ]);
    
            
            // Crear el usuario
            $user = new User([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'numero_identificacion' => $request->numero_identificacion,
                'idtipo_usuario' => $request->idtipo_usuario,
                'idtipo_documento' => $request->idtipo_documento,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : null,
                // 'foto' => $fotoPath,
            ]);


            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = 'fotos/' . $nombreImagen;
    
                // Almacenar la imagen en el almacenamiento
                $imagen->storeAs('public/' . $rutaImagen);
    
                // Guardar la ruta de la imagen en el modelo Producto
                $user->foto = $rutaImagen;
            }
    
            $user->save();
            
            return redirect()->route('UsuariosController.index')->with('success', 'Usuario añadido exitosamente.');

    } catch (ValidationException $e) {
        return back()->withErrors($e->validator->errors())->withInput();
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
    }
    

    public function updateFoto(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tamaño máximo 2MB
            ]);

            $user = User::findOrFail($request->user_id);

            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = 'fotos/' . $nombreImagen;

                // Almacenar la imagen en el almacenamiento
                $imagen->storeAs('public/' . $rutaImagen);

                // Eliminar la foto anterior si existe
                // if ($user->foto) {
                //     \Storage::delete('public/' . $user->foto);
                // }

                // Actualizar la ruta de la imagen en el modelo Usuario
                $user->foto = $rutaImagen;
            }

            $user->save();

            return redirect()->route('dashboard')->with('success', 'Foto actualizada exitosamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        $user = Auth::user();

        if (!$user) {
            return back()->withErrors(['error' => 'No se pudo encontrar el usuario autenticado.']);
        }

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;

        if ($request->hasFile('foto')) {
            // Eliminar la foto de perfil anterior si existe
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            // Guardar la nueva foto de perfil
            $imagen = $request->file('foto');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = 'fotos/' . $nombreImagen;
            $imagen->storeAs('public/' . $rutaImagen);

            $user->foto = $rutaImagen;
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado exitosamente');
    }
    
}
