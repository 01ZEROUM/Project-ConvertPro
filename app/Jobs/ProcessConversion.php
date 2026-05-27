<?php

namespace App\Jobs;

use App\Models\Conversion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

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

        $outputDir = public_path('downloads');

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // Nome base do arquivo (controlado pelo ID)
        $outputTemplate = $outputDir . '/' . $this->conversion->id . '.%(ext)s';

        // Comando yt-dlp
        $command = $format === 'mp3'
            ? [
                'yt-dlp',
                '-x',
                '--audio-format', 'mp3',
                '-o', $outputDir . '/' . $this->conversion->id . '.%(title)s ' . '[By. ConvertPro]',
                $url
            ]
            : [
                'yt-dlp',
                //'-f', 'bestvideo+bestaudio/best',
                '-f', 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]',
                '--merge-output-format', 'mp4',
                '-o', $outputDir . '/' . $this->conversion->id . '.%(title)s ' . '[By. ConvertPro]',
                $url
            ];

        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();

        // Se sucesso
        if ($process->isSuccessful()) {

            // pega arquivo gerado
            $files = glob($outputDir . '/' . $this->conversion->id . '*');

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
                'error_message' => $process->getErrorOutput()
            ]);
        }
    }
}