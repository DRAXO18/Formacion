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
     * @param  string  $controller
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $controller)
    {
        $user = Auth::user();
        $userRole = $user->id_rol;

        // Registrar el inicio del middleware
        Log::info("Middleware CheckAcceso iniciado para el usuario: {$user->id}, rol: {$userRole}, controlador requerido: {$controller}");

        // Obtener los id_acceso del rol del usuario
        $idAccesos = DB::table('permiso_acceso')
            ->where('id_rol', $userRole)
            ->pluck('id_acceso')
            ->toArray();

        // Obtener los nombres de los controladores permitidos para esos id_acceso
        $controladores = DB::table('accesos')
            ->whereIn('id', $idAccesos)
            ->pluck('controlador')
            ->map(function ($item) {
                return preg_replace('/\.index$/', '', $item);
            })
            ->toArray();

        // Registrar los controladores obtenidos
        Log::info("Controladores obtenidos para el rol {$userRole}: " . implode(', ', $controladores));

        // Verificar si el controlador está en la lista de controladores permitidos
        if (in_array($controller, $controladores)) {
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
