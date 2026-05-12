<?php
/**
 * Realizar la compra de un producto y descontar stock.
 * Purchase
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 * @author Nicolas hernandez
 * @since 2024/05
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login'])->middleware('limite_sesiones');


Route::middleware(['auth:sanctum', 'limite_sesiones'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Cualquier usuario logueado puede ver y comprar
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products/purchase', [ProductController::class, 'purchase']); 
    

    // --- SOLO ADMIN ---
    Route::middleware('es_admin')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        
    });
    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
    });
});
    