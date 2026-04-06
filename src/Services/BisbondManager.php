<?php

namespace AhsanUlAlam\LaravelBisbond\Services;

use AhsanUlAlam\LaravelBisbond\Models\BisbondSetting;
use AhsanUlAlam\LaravelBisbond\Support\BanglaFormatter;

class BisbondManager
{
    public function setting(string $key, mixed $default = null): mixed
    {
        $setting = BisbondSetting::query()->where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        return config('bisbond.defaults.' . $key, $default);
    }

    public function set(string $group, string $key, mixed $value, string $type = 'string'): BisbondSetting
    {
        return BisbondSetting::query()->updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
            ]
        );
    }

    public function formatter(): BanglaFormatter
    {
        return new BanglaFormatter();
    }
}
