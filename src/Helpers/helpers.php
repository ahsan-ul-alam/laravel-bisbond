<?php

use AhsanUlAlam\LaravelBisbond\Facades\Bisbond;

if (! function_exists('bisbond_setting')) {
    function bisbond_setting(string $key, mixed $default = null): mixed
    {
        return Bisbond::setting($key, $default);
    }
}

if (! function_exists('bn_digits')) {
    function bn_digits(string|int|float $value): string
    {
        return Bisbond::formatter()->digits($value);
    }
}

if (! function_exists('bn_money')) {
    function bn_money(string|int|float $amount, bool $symbol = true): string
    {
        return Bisbond::formatter()->money($amount, $symbol);
    }
}

if (! function_exists('bn_date')) {
    function bn_date(mixed $date): string
    {
        return Bisbond::formatter()->date($date);
    }
}
