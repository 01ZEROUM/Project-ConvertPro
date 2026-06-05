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
        return view('download', compact('conversion'));
    }

    // 2. ESSE MÉTODO FAZ O DOWNLOAD DO ARQUIVO QUANDO CLICA NO BOTÃO
    public function download(Request $request, $id)
    {
        $conversion = Conversion::findOrFail($id);

        if (!Auth::check() && $request->has('token')) {
            $tokenString = str_replace('Bearer ', '', $request->query('token'));
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($tokenString);
            if ($accessToken) {
                Auth::login($accessToken->tokenable);
            }
        }

        if (!Auth::check() || $conversion->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        if ($conversion->status !== 'completed' || !$conversion->file_path) {
            return response()->json(['message' => 'Arquivo ainda não está pronto'], 409);
        }

        $file = storage_path('app/public/downloads/' . $conversion->file_path);

        if (!file_exists($file)) {
            return response()->json(['message' => 'Arquivo não existe no servidor'], 404);
        }

        // CORREÇÃO: sanitiza o nome para remover caracteres unicode que quebram o header
        $extension = pathinfo($conversion->file_path, PATHINFO_EXTENSION);
        $cleanName = $this->sanitizeFileName($conversion->file_path, $extension);

        return response()->download($file, $cleanName);
    }

    // 3. LIMPA O NOME DO ARQUIVO PARA O DOWNLOAD
    private function sanitizeFileName(string $filePath, string $extension): string
    {
        $name = pathinfo($filePath, PATHINFO_FILENAME);

        // Remove o ID do início (ex: "136. ")
        $name = preg_replace('/^\d+\.\s*/', '', $name);

        // Substitui separadores unicode (｜, |, –, —) por hífen comum
        $name = str_replace(['｜', '|', '–', '—'], '-', $name);

        // Remove qualquer caractere que não seja letra, número, espaço, hífen ou colchete
        $name = preg_replace('/[^\w\s\-\[\]áéíóúàèìòùãõâêîôûçÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÇ]/u', '', $name);

        // Remove espaços duplos e trim
        $name = trim(preg_replace('/\s+/', ' ', $name));

        return $name . '.' . $extension;
    }
}