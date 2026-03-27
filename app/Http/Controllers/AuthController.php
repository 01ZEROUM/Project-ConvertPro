<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return response()->json([
            'message' => 'Usuário criado com sucesso',
        ]);
    }

    public function login()
    {
        return response()->json([
            'message' => 'Login realizado',
        ]);
    }

    public function logout()
    {
        return response()->json([
            'message' => 'Logout realizado',
        ]);
    }

    public function me()
    {
        return response()->json([
            'message' => 'Usuário',
        ]);
    }
}
