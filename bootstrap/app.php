<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/products')
                ->group(base_path('routes/products.php'));

            Route::middleware('api')
                ->prefix('api/auth')
                ->group(base_path('routes/auth.php'));

            Route::middleware('api')
                ->prefix('api/users')
                ->group(base_path('routes/user.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'es_admin' => \App\Http\Middleware\AdminMiddleware::class,
            'limite_sesiones' => \App\Http\Middleware\LimitActiveSessions::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
    
