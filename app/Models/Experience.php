<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'position_i18n',
        'company_i18n',
        'period_i18n',
        'responsibilities_i18n',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'position_i18n' => 'array',
        'company_i18n' => 'array',
        'period_i18n' => 'array',
        'responsibilities_i18n' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}