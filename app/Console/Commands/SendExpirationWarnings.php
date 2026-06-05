<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ConvertedFile;
use Illuminate\Support\Facades\Mail;
use App\Mail\FileExpirationWarningMail;

class SendExpirationWarnings extends Command
{
    protected $signature = 'files:send-warnings';

    protected $description = 'Envia aviso de expiração';

    public function handle()
    {
        $files = ConvertedFile::with('conversion.user')
            ->whereDate('expires_at', now()->addDay()->toDateString())
            ->whereNull('warning_email_sent_at')
            ->get();

       foreach ($files as $file) {

        $this->info("Arquivo ID: {$file->id}");
        $this->info("Conversion ID: {$file->conversion_id}");

        if (!$file->conversion) {
            $this->error("Conversão não encontrada.");
            continue;
        }

        if (!$file->conversion->user) {
            $this->error("Usuário não encontrado.");
            continue;
        }

        $this->info("Email: " . $file->conversion->user->email);

        Mail::to($file->conversion->user->email)
            ->send(new FileExpirationWarningMail($file));

        $file->update([
            'warning_email_sent_at' => now()
        ]);

        $this->info("Email enviado!");
    }
}
}