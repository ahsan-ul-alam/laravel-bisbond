<?php

namespace AhsanUlAlam\LaravelBisbond\Support;

use Carbon\Carbon;

class BanglaFormatter
{
    protected array $englishToBangla = [
        '0' => '০',
        '1' => '১',
        '2' => '২',
        '3' => '৩',
        '4' => '৪',
        '5' => '৫',
        '6' => '৬',
        '7' => '৭',
        '8' => '৮',
        '9' => '৯',
    ];

    protected array $months = [
        1 => 'জানুয়ারি',
        2 => 'ফেব্রুয়ারি',
        3 => 'মার্চ',
        4 => 'এপ্রিল',
        5 => 'মে',
        6 => 'জুন',
        7 => 'জুলাই',
        8 => 'আগস্ট',
        9 => 'সেপ্টেম্বর',
        10 => 'অক্টোবর',
        11 => 'নভেম্বর',
        12 => 'ডিসেম্বর',
    ];

    public function toBangla(string|int|float $value): string
    {
        return $this->digits($value);
    }

    public function digits(string|int|float $value): string
    {
        return strtr((string) $value, $this->englishToBangla);
    }

    public function money(string|int|float $amount, bool $symbol = true): string
    {
        $formatted = number_format((float) $amount, 2);
        return $symbol ? '৳' . $this->digits($formatted) : $this->digits($formatted);
    }

    public function date(mixed $date): string
    {
        $date = Carbon::parse($date);

        return $this->digits($date->day) . ' ' .
            ($this->months[$date->month] ?? $date->format('F')) . ' ' .
            $this->digits($date->year);
    }
}
