<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'key',
        'title_prefix_i18n',
        'title_highlight_i18n',
        'subtitle_i18n',
        'content_i18n',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'title_prefix_i18n' => 'array',
        'title_highlight_i18n' => 'array',
        'subtitle_i18n' => 'array',
        'content_i18n' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}