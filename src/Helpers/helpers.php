<?php

use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use AhsanUlAlam\LaravelBisbond\Support\BanglaFormatter;

if (!function_exists('bisbond_setting')) {
    /**
     * Access the Bisbond Setting Service or get a specific key value.
     */
    function bisbond_setting(string $key = null, mixed $default = null): mixed
    {
        $service = app(SettingService::class);
        return is_null($key) ? $service : $service->get($key, $default);
    }
}

if (!function_exists('bisbond_module')) {
    /**
     * Check if a specific Bisbond module is enabled.
     */
    function bisbond_module(string $module): bool
    {
        return app(SettingService::class)->isModuleEnabled($module);
    }
}

if (!function_exists('bn_digits')) {
    /**
     * Convert numbers to Bangla digits.
     */
    function bn_digits(mixed $number): string
    {
        return BanglaFormatter::toBangla($number);
    }
}

if (!function_exists('bn_money')) {
    /**
     * Format number as Bangla currency.
     */
    function bn_money(mixed $amount): string
    {
        $symbol = bisbond_setting('formatter.currency_symbol', '৳');
        return bn_digits($amount) . ' ' . $symbol;
    }
}

if (!function_exists('bn_date')) {
    /**
     * Convert date string to Bangla.
     */
    function bn_date(string $dateString): string
    {
        return BanglaFormatter::toBangla($dateString);
    }
}
