<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created user in storage. en 
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:8',
        ]);
    
        // Hash the password before storing
        $validatedData['password'] = Hash::make($validatedData['password']);
    
        $user = User::create($validatedData);
    
        return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user], 201);
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('lastname')) {
            $user->lastname = $request->lastname;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $user]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Usuario eliminado exitosamente']);
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Autenticación exitosa
        return response()->json(['message' => 'Inicio de sesión exitoso'], 200);
    }

    // Autenticación fallida
    return response()->json(['message' => 'Credenciales incorrectas'], 401);
}


}


