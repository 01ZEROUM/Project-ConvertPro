<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ConvertedFile;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredFiles extends Command
{
    protected $signature = 'files:delete-expired';

    protected $description = 'Remove arquivos expirados';

    public function handle()
    {
        $files = ConvertedFile::where('expires_at', '<=', now())->get();

        foreach ($files as $file) {

            if (Storage::disk('public')->exists('downloads/' . $file->file_path)) {
                Storage::disk('public')->delete('downloads/' . $file->file_path);
            }

            $file->delete();
        }

        $this->info('Arquivos expirados removidos.');
    }
}