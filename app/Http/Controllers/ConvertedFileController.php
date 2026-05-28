<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use Illuminate\Support\Facades\Auth;

class ConvertedFileController extends Controller
{
    
    public function index(Request $request)
    {

        $user = $request->user();
        $files = Conversion::where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json($files);
    }

    public function show()
    {
        return response()->json([
            'message' => 'Arquivo atualizado com sucesso',
        ]);
    }

    public function destroy(Request $request, $id)
    {
     
        $file = Conversion::findOrFail($id);

        if ($file->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Acesso negado. Você não tem permissão para excluir este arquivo.'
            ], 403);
        }

        $file->delete();

        return response()->json([
            'message' => "Arquivo " . $id . " deletado com sucesso!"
        ]);
    }
}

