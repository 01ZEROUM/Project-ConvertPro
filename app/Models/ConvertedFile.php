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

    protected $casts = [
        'size_in_bytes'         => 'integer',
        'is_downloadable'       => 'boolean',
        'expires_at'            => 'datetime',
        'warning_email_sent_at' => 'datetime',
    ];

    public function conversion()
    {
        return $this->belongsTo(Conversion::class);
    }
}