<?php

namespace AhsanUlAlam\LaravelBisbond\Support\Payments;

use AhsanUlAlam\LaravelBisbond\Contracts\PaymentProviderInterface;

abstract class BasePaymentProvider implements PaymentProviderInterface
{
    public function isEnabled(): bool
    {
        return (bool) bisbond_setting("payments.{$this->getId()}.enabled", false);
    }

    public function getCredential(string $key, mixed $default = null): mixed
    {
        return bisbond_setting("payments.{$this->getId()}.{$key}", $default);
    }

    public function getConfigFields(): array
    {
        return ['merchant_id', 'app_key', 'app_secret'];
    }
}
