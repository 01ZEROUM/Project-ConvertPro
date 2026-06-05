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
        return response()->json(
            Conversion::where('user_id', $request->user()->id)
                ->latest()
                ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'source' => 'required|url',
                'target_format' => 'required|in:mp3,mp4'
            ]);

            $conversion = Conversion::create([
                'user_id'       => $request->user()->id,
                'source'        => $request->source,
                'target_format' => $request->target_format,
                'source_type'   => 'youtube',
                'status'        => 'pending',
                'progress'      => 0,
                'started_at'    => now()
            ]);

            ProcessConversion::dispatch($conversion);

            return response()->json([
                'id' => $conversion->id,
                'status' => 'pending'
            ], 201);
        } catch (\Throwable $e) {

            Log::error('Erro ao criar conversão', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro interno ao processar a solicitação.'
            ], 500);
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

        $conversion->convertedFile()->delete();
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

        if ($conversion->status !== 'failed') {
            return response()->json([
                'message' => 'Só é possível retry em conversões falhas.'
            ], 422);
        }

        try {

            $conversion->update([
                'status' => 'pending',
                'progress' => 0,
                'started_at' => now(),
                'completed_at' => null,
                'error_message' => null,
                'job_id' => null
            ]);

            $conversion->refresh();

            ProcessConversion::dispatch($conversion);

            Log::info('Retry executado', [
                'user_id' => $request->user()->id,
                'conversion_id' => $conversion->id
            ]);

            return response()->json([
                'message' => 'Conversão reenviada com sucesso',
                'id' => $conversion->id,
                'status' => $conversion->status
            ]);
        } catch (\Throwable $e) {

            Log::error('Erro no retry', [
                'error' => $e->getMessage(),
                'conversion_id' => $id
            ]);

            return response()->json([
                'message' => 'Erro ao tentar reprocessar conversão'
            ], 500);
        }
    }
}
