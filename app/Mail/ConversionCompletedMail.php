<?php

namespace App\Mail;

use App\Models\ConvertedFile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConversionCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $file;

    public function __construct(ConvertedFile $file)
    {
        $this->file = $file;
    }

    public function build()
    {
        return $this
            ->subject('Sua conversão foi concluída - ConvertPro')
            ->view('conversion-completed');
    }
}