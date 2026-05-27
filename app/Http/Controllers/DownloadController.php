<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use Illuminate\Support\Facades\Auth;


class DownloadController extends Controller
{
    // 1. ESSE MÉTODO ABRE A PÁGINA (A VIEW)
    public function page($id)
    {
        $conversion = Conversion::findOrFail($id);

        // Segurança básica
        if (Auth::check() && $conversion->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para acessar este arquivo.');
        }

        // Garante que a variável 'conversion' está indo para a view download.blade.php
        return view('download', compact('conversion'));  
    }

    // 2. ESSE MÉTODO FAZ O DOWNLOAD DO ARQUIVO QUANDO CLICA NO BOTÃO
    public function download($id)
    {
        $conversion = Conversion::findOrFail($id);

        if (Auth::check() && $conversion->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        if ($conversion->status !== 'completed' || !$conversion->file_path) {
            return response()->json(['message' => 'Arquivo ainda não está pronto'], 409);
        }

        $file = storage_path('app/public/downloads/' . $conversion->file_path);

        if (!file_exists($file)) {
            return response()->json(['message' => 'Arquivo não existe no servidor'], 404);
        }

        return response()->download($file, basename($conversion->file_path));
    }
}