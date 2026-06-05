<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConvertedFile;

class ConvertedFileController extends Controller
{
    /**
     * Lista todos os arquivos do usuário autenticado
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $files = ConvertedFile::whereHas('conversion', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->latest()
        ->get();

        return response()->json($files);
    }

    /**
     * Mostra um arquivo específico
     */
    public function show(Request $request, $id)
    {
    $file = ConvertedFile::with('conversion')->findOrFail($id);

    if ($file->conversion->user_id !== $request->user()->id) {
        return response()->json([
            'message' => 'Acesso negado.'
        ], 403);
    }

    return response()->json($file);
    }

    /**
     * Deleta um arquivo convertido
     */
    public function destroy(Request $request, $id)
    {
        $file = ConvertedFile::with('conversion')->findOrFail($id);

        // segurança: só dono pode deletar
        if ($file->conversion->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Acesso negado.'
            ], 403);
        }

        $file->delete();

        return response()->json([
            'message' => 'Arquivo deletado com sucesso!'
        ]);
    }
}