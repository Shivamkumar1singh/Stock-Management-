<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable=['key','value'];

    public static function getValue($key, $default = 0)
    {
        return cache()->remember(
            "setting_$key",
            now()->addDay(),
            fn () => static::where('key', $key)->value('value') ?? $default
        );
    }
    
}
