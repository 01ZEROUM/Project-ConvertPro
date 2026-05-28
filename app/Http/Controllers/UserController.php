<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function index() {
    $usuarios = User::select('name', 'email')->get();
    
        return response()->json([
            $usuarios
        ]);
    }
    public function store(Request $request) {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        return response()->json([
            'message' => 'store'
        ]);
    }
    public function show(string $id) {
        $usuario = User::select('name', 'email')->find($id);
        return response()->json([
            $usuario
        ]);
    }

    public function email(string $email) {
        $usuario = User::select('name', 'email')->where('email', '=', $email)->get();
    
        return response()->json([
            $usuario
        ]);
    }

    public function update(Request $request, string $id) {
        User::find($id)->update(["name"=>$request->nome, "email"=>$request->email]);
        return response()->json([
            'message' => "Usuário alterado com sucesso! ID: {$id}"
        ]);
    }
    public function destroy(string $id) {
        User::find($id)->delete();
        return response()->json([
            'message' => "Usuário deletado com sucesso!. ID: {$id}"
        ]);
    }
}

