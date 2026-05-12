<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
 * Realizar la compra de un producto y descontar stock.
 * Purchase
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 * @author Nicolas hernandez
 * @since 2024/05
 */
    public function index()
    {
        //todos los usuarios de la base de datos
        $users = User::all();

        //devolver en formato json
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => ['required',
            'string',
            'min:8', // Mínimo 8 caracteres
            'regex:/[a-z]/', // Al menos una letra minúscula
            'regex:/[A-Z]/', // Al menos una letra mayúscula
            'regex:/[0-9]/', // Al menos un número
            'regex:/[@$!%*?&#]/', // Al menos un carácter especial
            ],
            'role' => 'required|in:ADMIN,USER',
        ]);
        // crear usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> bcrypt($request->password), //Encriptar la contraseña
            'role' => $request->role,
        ]);
        // respuesta
        return response()->json([
            'message' => 'Usuario creado exitosamente por el Administrador',
            'data' => $user
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //usuario po ID
        $user = User::findOrFail($id);

        //si el usuario no existe, devuelve un error
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
                ], 404);
    }
        //devolver el usuario en formato json
        return response()->json([
            'message' => 'Usuario obtenido exitosamente',
            'data' => $user
        ], 200);
    }
    /**
    * Actualizar datos o rol de un usuario.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    * @author Nicolás
    */

    public function update(Request $request, string $id)
    {
        // buscar usuario
        $user = User::findOrFail($id);

        if (!$user){
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        //validar datos con la excepción de email
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email'=>'sometimes|reuired|string|email|unique:users,email,'.$user->id,
            'role' => 'sometimes|required|in:ADMIN,USER',
        ]);
        //actualizar usuario
        $user->update($request->only(['name', 'email', 'role']));
        //respuesta
        return response()->json([
            'message' => 'Usuario actualizado exitosamente por el Administrador',
            'data' => $user
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // buscar usuario
        $user = user::findOrFail($id);
        //validacion de existencia
        if (!$user){
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        //eliminar usuario
        $user->delete();
        //respuesta
        return response()->json([
            'message' => 'Usuario eliminado exitosamente por el Administrador'
        ], 200);
    }
}
