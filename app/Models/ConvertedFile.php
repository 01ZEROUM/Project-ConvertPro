<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvertedFile extends Model
{
    protected $table = 'converted_files';

    protected $fillable = [
        'conversion_id',
        'file_path',
        'file_name',
        'mime_type',
        'size_in_bytes',
        'disk',
        'is_downloadable',
        'expires_at',
        'warning_email_sent_at'
    ];

    public function conversion()
    {
        return $this->belongsTo(Conversion::class);
    }
}