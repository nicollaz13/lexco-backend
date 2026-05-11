<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LimitActiveSessions
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Contamos los tokens de acceso personal en la base de datos
    $activeSessions = \Laravel\Sanctum\PersonalAccessToken::count();

    // Bloqueamos si hay 2 o más, a menos que esté cerrando sesión
    if ($activeSessions >= 2 && !$request->is('api/auth/logout')) {
        return response()->json([
            'message' => 'Límite de usuarios simultáneos alcanzado (Máximo 2)'
        ], 403);
    }
        return $next($request);
    }
}
