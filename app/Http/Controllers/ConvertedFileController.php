<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class ConvertedFileController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Arquivos convertidos',
        ]);
    }

    public function show()
    {
        return response()->json([
            'message' => 'Arquivo atualizado com sucesso',
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => "Arquivo " . $id . " deletado com sucesso"
        ]);
    }
}
