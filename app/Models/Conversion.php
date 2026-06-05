<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Conversion extends Model
{
    protected $table = 'conversions';

    protected $fillable = [
        'user_id',
        'source',
        'source_type',
        'target_format',
        'status',
        'job_id',
        'error_message',
        'started_at',
        'completed_at',
        'file_path',
        'progress'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

    public function convertedFile()
{
    return $this->hasOne(ConvertedFile::class);
}

}