<?php

namespace AhsanUlAlam\LaravelBisbond\Support\Payments;

class NagadProvider extends BasePaymentProvider
{
    public function getId(): string { return 'nagad'; }
    public function getName(): string { return 'Nagad'; }
    public function getIcon(): string { return 'fas fa-mobile-screen'; }
}
