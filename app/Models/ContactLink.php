<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLink extends Model
{
    protected $fillable = [
        'type',
        'icon',
        'label_i18n',
        'url',
        'copy_value',
        'target',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'label_i18n' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}