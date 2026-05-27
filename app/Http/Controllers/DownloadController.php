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

    // 1. Segurança (Mantido)
    if (Auth::check() && $conversion->user_id !== Auth::id()) {
        abort(403, 'Acesso negado.');
    }

    // 2. CORREÇÃO: Verifique se o nome da coluna no seu banco é exatamente 'file_path'.
    // Se no banco for apenas 'file' ou 'path', mude aqui embaixo:
    if (!$conversion->file_path) {
        return response()->json([
            'message' => 'O registro existe, mas o nome do arquivo não foi salvo no banco.'
        ], 409);
    }

    // 3. AJUSTE DO CAMINHO: Vamos montar o caminho usando a pasta public correta
    $file = storage_path('app/public/downloads/' . $conversion->file_path);

    // Se você não usou a pasta 'downloads' na hora de salvar no Job, mude para:
    // $file = storage_path('app/public/' . $conversion->file_path);

    if (!file_exists($file)) {
        return response()->json([
            'message' => 'O status está concluído, mas o arquivo não foi encontrado na pasta do servidor.',
            'caminho_tentado' => $file // Isso vai te ajudar a descobrir onde o Laravel está procurando
        ], 404);
    }

    // 4. Se tudo deu certo, força o download com o nome original
    return response()->download($file, basename($conversion->file_path));
}
}