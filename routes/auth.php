<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// El límite SOLO va aquí
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('limite_sesiones');

// Quitamos 'limite_sesiones' de este grupo
Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'profile']);
    Route::put('/user-profile', [AuthController::class, 'updateProfile']);
});