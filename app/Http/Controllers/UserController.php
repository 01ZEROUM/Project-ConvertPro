<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::select('id', 'name', 'email')->get();

        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'user' => $usuario
        ]);
    }

    public function show(string $id)

    {
        
        $usuario = User::select('id', 'name', 'email', 'is_admin')->find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        return response()->json($usuario);
    }

    public function email(string $email)
    {
        $usuario = User::select('id', 'name', 'email')
            ->where('email', $email)
            ->get();

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        return response()->json($usuario);
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->update([
            'name' => $request->name ?? $usuario->name,
            'email' => $request->email ?? $usuario->email,
            "is_admin" => $request->is_admin ?? $usuario->is_admin
        ]);

        return response()->json([
            'message' => "Usuário alterado com sucesso! ID: {$id}"
        ]);
    }

    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->delete();

        return response()->json([
            'message' => "Usuário deletado com sucesso! ID: {$id}"
        ]);
        
    }

    public function admins(){
        $admins = User::where('is_admin', 1)
        ->select('id', 'name', 'email')
        ->get();

        return response()->json($admins);
    }
}

