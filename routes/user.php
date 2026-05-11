<?php
    use App\Http\Controllers\UserController;
    use illuminate\Support\Facades\Route;

    //solo El admin lo puede gestionar
    Route::middleware(['auth:sanctum', 'es_admin'])->group(function () {
        //ver lista de todos los usuarios
        Route::get('/', [UserController::class, 'index']);

    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    route::put('/{id}', [UserController::class, 'update']);
    route::delete('/{id}', [UserController::class, 'destroy']);
    });