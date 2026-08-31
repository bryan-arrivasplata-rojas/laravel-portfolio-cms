<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'filename',
        'original_name',
        'mime_type',
        'size_bytes',
        'disk',
        'path',
        'public_url',
    ];
}