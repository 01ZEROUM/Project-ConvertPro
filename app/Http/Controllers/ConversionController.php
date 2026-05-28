<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use App\Jobs\ProcessConversion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConversionController extends Controller
{

    public function index(Request $request)
    {
        $conversions = Conversion::where('user_id', $request->user()->id)->latest()->get();
        return response()->json($conversions);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'source' => 'required|url',
                'target_format' => 'required|in:mp3,mp4'
            ]);

            $conversion = Conversion::create([
                'user_id'       => Auth::id(), 
                'source'        => $request->source,
                'target_format' => $request->target_format,
                'source_type'   => 'youtube',
                'status'        => 'pending',
                'progress'      => 0
            ]);

            ProcessConversion::dispatch($conversion);

            return response()->json([
                'id'     => $conversion->id,
                'status' => 'pending'
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erro ao criar conversão', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro interno ao processar a solicitação.'], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $conversion = Conversion::findOrFail($id);
        
        if ($conversion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }
        
        return response()->json($conversion);
    }

    public function destroy(Request $request, $id)
    {
        $conversion = Conversion::findOrFail($id);
        
        if ($conversion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $conversion->delete();
        return response()->json(['message' => 'Conversão deletada com sucesso']);
    }

    public function status(Request $request, $id)
    {
        $conversion = Conversion::findOrFail($id);
        
        if ($conversion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        return response()->json([
            'id' => $conversion->id,
            'status' => $conversion->status,
            'started_at' => $conversion->started_at,
            'completed_at' => $conversion->completed_at,
            'progress' => $conversion->progress ?? 0
        ]);
    }

    public function retry(Request $request, $id)
    {
        $conversion = Conversion::findOrFail($id);
        
        if ($conversion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }
        
        if (!in_array($conversion->status, ['failed', 'error'])) {
            return response()->json(['message' => 'Só é possível retry em conversões falhas.'], 422);
        }

        $conversion->update([
            'status' => 'pending',
            'progress' => 0,
        ]);

        ProcessConversion::dispatch($conversion);

        return response()->json(['message' => 'Conversão reenviada com sucesso']);
    }
}