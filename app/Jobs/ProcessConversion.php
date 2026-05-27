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

    if ($format === 'mp3') {

        $command = [
            'yt-dlp',
            '-x',
            '--audio-format', 'mp3',
            '-o', public_path('downloads/' . $this->conversion->id . '-%(title)s.%(ext)s'),
            $url
        ];

    } else {

        $command = [
            'yt-dlp',
            '-f', 'bestvideo+bestaudio/best',
            '-o', public_path('downloads/' . $this->conversion->id . '-%(title)s.%(ext)s'),
            $url
        ];
    }

    $process = new Process($command);
    $process->setTimeout(3600);
    $process->run();

    // pega arquivo gerado
    $outputPath = public_path('downloads');
    $files = glob($outputPath . '/*');

    $latestFile = !empty($files)
        ? collect($files)->sortByDesc(fn($file) => filemtime($file))->first()
        : null;

    if ($process->isSuccessful()) {

        $this->conversion->update([
            'status' => 'completed',
            'completed_at' => now(),
            'file_path' => $latestFile ? basename($latestFile) : null
        ]);

    } else {

        $this->conversion->update([
            'status' => 'failed',
            'error_message' => $process->getErrorOutput()
        ]);
    }
}

}