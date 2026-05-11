<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
/**
 * Registra un nuevo usuario y le asigna un rol automáticamente.
 * El primer usuario registrado es ADMIN, los demás son USER.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @author nicolas hernandez
 * @since 2026/05
 */ 
    public function register(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'string',
            'min:8', // Mínimo 8 caracteres
            'regex:/[a-z]/', // Al menos una letra minúscula
            'regex:/[A-Z]/', // Al menos una letra mayúscula
            'regex:/[0-9]/', // Al menos un número
            'regex:/[@$!%*?&#]/', // Al menos un carácter especial

        ],
    ]);
    // Cuantos usuarios existen
    $userCount = \App\Models\User::count();
    // Si no hay usuarios, el primero será ADMIN, sino USER
    $role = ($userCount === 0) ? 'ADMIN' : 'USER';
    
    // Crear el usuario en la base de datos
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => $role,
    ]);

    // 4. respuesta
    return response()->json([
        'message' => 'Usuario registrado exitosamente',
        'user' => $user,
    ], 201);
}
public function login(Request $request){
    //revisa que los espacios no esten vacios
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    // Busca el usuario por email
    $user = user::where('email', $request->email)->first();
    // se revisa si ya existe y la contraseña es correcta
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }
    //generar token
    $token = $user->createToken('auth_token')->plainTextToken;

    // cookie httponly
    $cookie = cookie(
        'auth_token', //nombre token
        $token, //token
        60 * 24, // dura un dia el token
        '/', // Disponible para todo el mundo el dominio
        null, // dominio (null para el dominio actual)
        false, // secure: false porque estamos en HTTP (en producción es true)
        true   // httpOnly
    );
    //respuesta
    return response()->json([
        'message' => '¡Bienvenido, ' . $user->name . '!',
        'token' => $token, // esta línea es para ver el código
        'user' => $user,
        'role' => $user->role
    ])->withCookie($cookie);
}
/**
 * Cierra la sesión del usuario, eliminando el token y la cookie.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @author Nicolas hernandez
 * @since 2026/05
 */
public function logout(Request $request)
{
    // 1. Eliminar el token de la base de datos)
    $request->user()->currentAccessToken()->delete();
    // 2. Eliminar la cookie del cliente
    $cookie = \Illuminate\Support\Facades\Cookie::forget('auth_token');

    return response()->json([
        'message' => 'Sesión cerrada. ¡Vuelve pronto!'
    ])->withCookie($cookie);
}
}