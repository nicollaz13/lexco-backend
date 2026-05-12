<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Punto de Entrada
|--------------------------------------------------------------------------
*/

// Cargamos las rutas de Autenticación y Perfil
Route::group([], base_path('routes/auth.php'));

// Cargamos las rutas de Productos (Prefijo: /api/products)
Route::prefix('products')->group(base_path('routes/products.php'));

// Cargamos las rutas de Usuarios (Prefijo: /api/users)
Route::prefix('users')->group(base_path('routes/user.php'));