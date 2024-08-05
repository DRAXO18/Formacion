<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfigController extends Controller
{
    // Mostrar la vista de configuración
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        return view('config', compact('user')); // Pasar el usuario a la vista
    }

    // Enviar el correo de verificación
    public function sendVerificationEmail()
    {
        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('configuracion.index')->with('status', 'Verificación de correo electrónico enviada.');
        }

        return redirect()->route('configuracion.index')->with('status', 'El correo electrónico ya está verificado.');
    }

    // Actualizar la contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('configuracion.index')->with('status', 'Contraseña actualizada exitosamente.');
    }
}

