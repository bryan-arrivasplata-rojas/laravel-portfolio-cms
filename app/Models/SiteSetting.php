<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value_i18n', 'group', 'type'];

    protected $casts = [
        'value_i18n' => 'array',
    ];

    public static function getVal(string $key, string $locale = 'es', $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        if (is_array($setting->value_i18n)) {
            return $setting->value_i18n[$locale] ?? $setting->value_i18n['value'] ?? $setting->value_i18n['es'] ?? $default;
        }

        return $setting->value_i18n ?? $default;
    }
}