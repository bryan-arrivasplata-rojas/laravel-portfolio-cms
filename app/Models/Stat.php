<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = ['number', 'label_i18n', 'sort_order', 'is_visible'];

    protected $casts = [
        'label_i18n' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}