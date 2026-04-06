<?php

namespace AhsanUlAlam\LaravelBisbond\Support\Payments;

class BkashProvider extends BasePaymentProvider
{
    public function getId(): string { return 'bkash'; }
    public function getName(): string { return 'bKash'; }
    public function getIcon(): string { return 'fas fa-mobile-alt'; }
}
