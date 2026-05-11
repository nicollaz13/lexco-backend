<?php

use illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// rutas publicas 
Route::get('/', [ProductController::class, 'index']);
Route::get('/{id}', [ProductController::class, 'show']);

// rutas privadas
Route::middleware(['auth:sanctum', 'es_admin'])->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

