<?php

namespace AhsanUlAlam\LaravelBisbond\Services;

use AhsanUlAlam\LaravelBisbond\Models\BisbondSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingService
{
    protected string $cacheKey = 'bisbond_settings_all_meta';

    /**
     * In-memory map:
     * [
     *   'general.business_name' => [
     *       'value' => 'My Business',
     *       'type'  => 'string',
     *       'group' => 'general',
     *   ],
     * ]
     */
    protected array $settingsMap = [];

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * Load all settings and metadata into memory.
     */
    protected function loadSettings(): void
    {
        $this->settingsMap = Cache::rememberForever($this->cacheKey, function () {
            return BisbondSetting::query()
                ->get()
                ->keyBy('key')
                ->map(function ($item) {
                    return [
                        'value' => $item->value,
                        'type'  => $item->type,
                        'group' => $item->group,
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Get a setting value by key with config fallback.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->settingsMap)) {
            $data = $this->settingsMap[$key];

            return $this->castValue($data['value'], $data['type']);
        }

        return Config::get("bisbond.$key", $default);
    }

    /**
     * Return all settings as flat key => casted value.
     */
    public function all(): array
    {
        $settings = [];

        foreach ($this->settingsMap as $key => $data) {
            $settings[$key] = $this->castValue($data['value'], $data['type']);
        }

        return $settings;
    }

    /**
     * Return settings grouped by group name.
     */
    public function grouped(): array
    {
        $grouped = [];

        foreach ($this->settingsMap as $key => $data) {
            $group = $data['group'] ?: 'general';

            $grouped[$group][$key] = $this->castValue($data['value'], $data['type']);
        }

        ksort($grouped);

        return $grouped;
    }

    /**
     * Set or update a single setting.
     */
    public function set(string $key, mixed $value, string $group = 'general', ?string $type = null): void
    {
        $type = $type ?? $this->determineType($value);

        BisbondSetting::query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $this->serializeValue($value),
                'group' => $group,
                'type'  => $type,
            ]
        );

        $this->refresh();
    }

    /**
     * Bulk update settings.
     */
    public function setMany(array $settings, string $group = 'general'): void
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value, $group);
        }
    }

    /**
     * Check if a module is enabled.
     */
    public function isModuleEnabled(string $module): bool
    {
        return (bool) $this->get(
            "modules.$module",
            Config::get("bisbond.modules.$module", false)
        );
    }

    /**
     * Clear cache and reload memory map.
     */
    public function refresh(): void
    {
        Cache::forget($this->cacheKey);
        $this->loadSettings();
    }

    /**
     * Cast raw stored value into proper PHP type.
     */
    protected function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer', 'int'  => (int) $value,
            'float', 'double' => (float) $value,
            'array', 'json'   => is_array($value) ? $value : (json_decode($value, true) ?? []),
            default           => $value,
        };
    }

    /**
     * Serialize value for DB storage.
     */
    protected function serializeValue(mixed $value): string
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return (string) $value;
    }

    /**
     * Detect setting type automatically.
     */
    protected function determineType(mixed $value): string
    {
        return match (true) {
            is_bool($value)  => 'boolean',
            is_int($value)   => 'integer',
            is_float($value) => 'float',
            is_array($value) => 'array',
            default          => 'string',
        };
    }
}
