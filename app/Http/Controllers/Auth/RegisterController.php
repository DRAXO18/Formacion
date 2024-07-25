<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear usuario en la tabla users
        $user = User::create([
            'nombre' => $request->username, // Cambiado a username
            'apellido' => $request->apellido,
            'numero_identificacion' => $request->numero_identificacion,
            'idtipo_usuario' => $request->idtipo_usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Autenticar al usuario después de crearlo
        auth()->login($user);

        session()->flash('welcome_name', $user->nombre);

        return redirect()->route('dashboard'); // Redirigir al dashboard o cualquier ruta deseada
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'apellido' => ['required', 'string', 'max:255'],
            'numero_identificacion' => ['required', 'string', 'max:255'],
            'idtipo_usuario' => ['required', 'integer'], // Añadir esta validación
        ]);
    }
}
