<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckAcceso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();
        $userRole = $user->id_rol;

        // Registrar el inicio del middleware
        Log::info("Middleware CheckAcceso iniciado para el usuario: {$user->id}, rol: {$userRole}, permiso requerido: {$permission}");

        // Obtener los permisos de acceso para el rol del usuario
        $permisos = DB::table('permiso_acceso')->where('id_rol', $userRole)->pluck('id_acceso');

        // Registrar los permisos obtenidos
        Log::info("Permisos obtenidos para el rol {$userRole}: " . $permisos->implode(', '));

        // Verificar si el permiso está en la lista de permisos del usuario
        if ($permisos->contains($permission)) {
            // Registrar el permiso concedido
            Log::info("Permiso concedido para el usuario: {$user->id}");
            return $next($request);
        }

        // Registrar el permiso denegado
        Log::warning("Permiso denegado para el usuario: {$user->id}, se redirige al dashboard");

        // Redirigir o mostrar error si el usuario no tiene permiso
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
