<?php
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// Quitamos 'limite_sesiones' de aquí
Route::middleware(['auth:sanctum', 'es_admin'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [AuthController::class, 'register']); 
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});