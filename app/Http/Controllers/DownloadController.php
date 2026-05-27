<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Conversion;

class DownloadController extends Controller
{
    public function download($id)
{
    $conversion = Conversion::findOrFail($id);

    if ($conversion->status !== 'completed' || !$conversion->file_path) {
        return response()->json([
            'message' => 'Arquivo ainda não está pronto'
        ], 404);
    }

    $file = public_path('downloads/' . $conversion->file_path);

    if (!file_exists($file)) {
        return response()->json([
            'message' => 'Arquivo não existe no servidor'
        ], 404);
    }

    return response()->download($file);
}
}