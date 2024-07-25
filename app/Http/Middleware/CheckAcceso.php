<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// class CheckAcceso
// {
//     public function handle($request, Closure $next, $acceso)
//     {
//         if (Auth::check() && Auth::user()->hasAcceso($acceso)) {
//             return $next($request);
//         }

//         return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
//     }
// }
