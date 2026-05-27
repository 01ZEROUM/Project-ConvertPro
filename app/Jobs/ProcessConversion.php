<?php

namespace App\Jobs;

use App\Models\Conversion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class ProcessConversion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $conversion;

    public function __construct(Conversion $conversion)
    {
        $this->conversion = $conversion;
    }

    public function handle()
    {
        $url = $this->conversion->source;
        $format = $this->conversion->target_format;
        $outputDir = storage_path('app/public/downloads');

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // Nome base do arquivo (controlado pelo ID)
        $outputTemplate = $outputDir . '/' . $this->conversion->id . '. %(title)s [By. ConvertPro].%(ext)s';

        // Comando yt-dlp
        $command = $format === 'mp3'
            ? [
                'yt-dlp',
                '-x',
                '--audio-format', 'mp3',
                '--audio-quality', '0',
                '-o', $outputTemplate,
                $url
            ]
            : [
                'yt-dlp',
                '-f', 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]',
                '--merge-output-format', 'mp4',
                '-o', $outputTemplate,
                $url
            ];

        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();

        // Se sucesso
        if ($process->isSuccessful()) {
            // pega arquivo gerado
            $files = glob($outputDir . '/' . $this->conversion->id . '. *');

            $latestFile = collect($files)
                ->sortByDesc(fn($file) => filemtime($file))
                ->first();

            if ($latestFile && file_exists($latestFile)) {
                $this->conversion->update([
                    'status' => 'completed',
                    'file_path' => basename($latestFile),
                    'completed_at' => now()
                ]);
            } else {
                $this->conversion->update([
                    'status' => 'failed',
                    'error_message' => 'Arquivo não foi gerado corretamente'
                ]);
            }
        } else {
            $this->conversion->update([
                'status' => 'failed',
                'error_message' => $process->getErrorOutput() ?: 'Erro desconhecido no yt-dlp'
            ]);
            
            Log::error('ProcessConversion failed', [
                'conversion_id' => $this->conversion->id,
                'error' => $process->getErrorOutput()
            ]);
        }
    }
}