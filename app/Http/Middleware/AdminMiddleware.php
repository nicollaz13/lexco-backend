<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // tiene permisos de admin
        if(auth()->user()->role !== 'ADMIN'){
            return response()->json(['message' => 'Acceso denegado'], 403);
        }
        return $next($request);
    }
}
