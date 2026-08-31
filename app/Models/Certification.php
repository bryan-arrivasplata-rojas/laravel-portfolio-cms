<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'icon',
        'name_i18n',
        'organization_i18n',
        'date_i18n',
        'icon_color',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'name_i18n' => 'array',
        'organization_i18n' => 'array',
        'date_i18n' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}