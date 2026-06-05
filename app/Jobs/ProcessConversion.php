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
use App\Models\ConvertedFile;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConversionCompletedMail;





class ProcessConversion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $conversion;
    public $tries = 3;
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
        $outputTemplate = $outputDir . '/' . $this->conversion->id . '. %(title)s [By. ConvertPro].%(ext)s';
        $ytDlp = '/home/joao/.local/bin/yt-dlp';
        $command = $format === 'mp3'
            ? [
                $ytDlp,
                '-x',
                '--audio-format',
                'mp3',
                '--audio-quality',
                '0',
                '-o',
                $outputTemplate,
                $url
            ]
            : [
                $ytDlp,
                '-f',
                'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]',
                '--merge-output-format',
                'mp4',
                '-o',
                $outputTemplate,
                $url
            ];
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();
        if ($process->isSuccessful()) {
            $files = glob($outputDir . '/' . $this->conversion->id . '.*');
            $latestFile = collect($files)
                ->sortByDesc(fn($file) => filemtime($file))
                ->first();
            if ($latestFile && file_exists($latestFile)) {
                // CORREÇÃO: sanitiza o nome do arquivo antes de salvar no banco
                $cleanBasename = $this->sanitizeFileName(basename($latestFile));
                $cleanPath = $outputDir . '/' . $cleanBasename;

                // Renomeia o arquivo no disco para o nome limpo
                if ($latestFile !== $cleanPath) {
                    rename($latestFile, $cleanPath);
                }

                $this->conversion->update([
                    'status'       => 'completed',
                    'file_path'    => $cleanBasename,
                    'completed_at' => now()
                ]);
                ConvertedFile::updateOrCreate(
                    ['conversion_id' => $this->conversion->id],
                    [
                        'file_path'      => $cleanBasename,
                        'file_name'      => $cleanBasename,
                        'mime_type'      => mime_content_type($cleanPath) ?: 'application/octet-stream',
                        'size_in_bytes'  => file_exists($cleanPath) ? filesize($cleanPath) : 0,
                        'disk'           => 'public',
                        'is_downloadable' => true,
                        'expires_at'     => now()->addDays(7)
                    ]
                );

                Mail::to($this->conversion->user->email)->
                send(new ConversionCompletedMail($this->conversion->convertedFile));

                
            } else {
                $this->conversion->update([
                    'status'        => 'failed',
                    'error_message' => 'Arquivo não foi gerado corretamente'
                ]);
            }
        } else {
            $this->conversion->update([
                'status'        => 'failed',
                'error_message' => $process->getErrorOutput() ?: 'Erro desconhecido no yt-dlp'
            ]);
            Log::error('ProcessConversion failed', [
                'conversion_id' => $this->conversion->id,
                'error'         => $process->getErrorOutput()
            ]);
        }
    }

    // CORREÇÃO: sanitiza o nome do arquivo removendo caracteres unicode problemáticos
    private function sanitizeFileName(string $filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name      = pathinfo($filename, PATHINFO_FILENAME);

        // Substitui separadores unicode (｜, |, –, —) por hífen comum
        $name = str_replace(['｜', '|', '–', '—'], '-', $name);

        // Remove qualquer caractere que não seja letra, número, espaço, hífen, ponto ou colchete
        $name = preg_replace('/[^\w\s\-\[\]áéíóúàèìòùãõâêîôûçÁÉÍÓÚÀÈÌÒÙÃÕÂÊÎÔÛÇ]/u', '', $name);

        // Remove espaços duplos e trim
        $name = trim(preg_replace('/\s+/', ' ', $name));

        return $name . '.' . $extension;
    }
}
