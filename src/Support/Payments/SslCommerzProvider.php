<?php

namespace AhsanUlAlam\LaravelBisbond\Support\Payments;

class SslCommerzProvider extends BasePaymentProvider
{
    public function getId(): string { return 'sslcommerz'; }
    public function getName(): string { return 'SSLCommerz'; }
    public function getIcon(): string { return 'fas fa-shield-alt'; }
    public function getConfigFields(): array { return ['store_id', 'store_password']; }
}
