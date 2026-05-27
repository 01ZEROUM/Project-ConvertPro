<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 1. REGISTRO DE USUÁRIO
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Cria o token do Sanctum para o usuário recém-cadastrado
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    // 2. LOGIN (GERAÇÃO DE TOKEN)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verifica se o usuário existe e se a senha está correta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais informadas estão incorretas.'],
            ]);
        }

        // Revoga tokens antigos se quiser permitir apenas um dispositivo logado por vez (Opcional)
        $user->tokens()->delete();

        // Cria o novo token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    // 3. LOGOUT (REVOGAÇÃO DO TOKEN)
    public function logout(Request $request)
    {
        // Apaga o token atual que está sendo usado na requisição
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revogado e logout realizado com sucesso!'
        ], 200);
    }

    // 4. RETORNAR USUÁRIO LOGADO (ME)
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}