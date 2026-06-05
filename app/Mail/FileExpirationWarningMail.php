<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FileExpirationWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function build()
    {
        return $this
            ->subject('⚠️ Seu arquivo expirará em breve')
            ->view('file-expiration-warning')
            ->with([
                'file' => $this->file
            ]);
    }
}