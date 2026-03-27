<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
public function index()
    {
       // Vai no banco de dados e pega todos os usuários
    $usuarios = User::all();
        return response()->json([
        'mensagem' => 'Lista de usuários recuperada com sucesso',
        'quantidade' => $usuarios->count(),
        'dados' => $usuarios
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // 2. (POST /api/users)
    public function store(Request $request)
    {
      $novoUsuario = User::create($request->all());
        return response()->json([
            'mensagem' => 'Usuário CRIADO com sucesso',
            'dados' => $novoUsuario
        ], 201); 
    }

    public function show($id)
    {
        //busca o usuário com o id específico
    $usuario = User::find($id);
        // Se não achar o usuário, devolve 404 
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        return response()->json([
            'mensagem' => 'Usuário encontrado',
            'dados' => $usuario
        ], 200);
    }

    // 4. ATUALIZAR (PUT /api/users/{id})
    public function update(Request $request, $id)
    {
       $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        // Atualiza os dados no banco
        $usuario->update($request->all());
        return response()->json([
            'mensagem' => 'Usuário ATUALIZADO com sucesso',
            'dados' => $usuario
        ], 200);
    }

    // 5. DELETAR (DELETE /api/users/{id})
    public function delete($id)
    {
       $usuario = User::find($id);
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        // Deleta do banco de dados
        $usuario->delete();
        return response()->json([
            'mensagem' => 'Usuário DELETADO com sucesso'
        ], 200);

    }
}
