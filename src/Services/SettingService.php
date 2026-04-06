<?php

namespace AhsanUlAlam\LaravelBisbond\Services;

use AhsanUlAlam\LaravelBisbond\Models\BisbondSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingService
{
    protected string $cacheKey = 'bisbond_settings';

    /**
     * Get a setting value by key.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        if (array_key_exists($key, $settings)) {
            return $settings[$key];
        }

        return Config::get("bisbond.$key", $default);
    }

    /**
     * Set a setting value.
     */
    public function set(string $key, mixed $value, string $group = 'general', string $type = 'string'): void
    {
        BisbondSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type
            ]
        );

        $this->forgetCache();
    }

    /**
     * Get all settings from DB.
     */
    public function all(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            return BisbondSetting::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Set multiple settings at once.
     */
    public function setMany(array $settings, string $group = 'general'): void
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value, $group);
        }
    }

    /**
     * Clear the settings cache.
     */
    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * Check if a module is enabled.
     */
    public function isModuleEnabled(string $module): bool
    {
        return (bool) $this->get("modules.$module", Config::get("bisbond.modules.$module", false));
    }
}
