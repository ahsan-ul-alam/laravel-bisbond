<?php

namespace AhsanUlAlam\LaravelBisbond\Models;

use Illuminate\Database\Eloquent\Model;

class BisbondSetting extends Model
{
    protected $table = 'bisbond_settings';

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}
