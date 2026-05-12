<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Quitamos 'limite_sesiones' de aquí
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/purchase', [ProductController::class, 'purchase']);
    
    Route::middleware('es_admin')->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
});