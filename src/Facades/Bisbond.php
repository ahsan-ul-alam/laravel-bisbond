<?php

namespace AhsanUlAlam\LaravelBisbond\Facades;

use Illuminate\Support\Facades\Facade;

class Bisbond extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bisbond';
    }
}
