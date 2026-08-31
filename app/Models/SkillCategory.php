<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillCategory extends Model
{
    protected $fillable = ['icon', 'name_i18n', 'animation_class', 'sort_order', 'is_visible'];

    protected $casts = [
        'name_i18n' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }
}