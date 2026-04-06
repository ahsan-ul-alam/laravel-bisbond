<?php

namespace AhsanUlAlam\LaravelBisbond\Support\Payments;

class RocketProvider extends BasePaymentProvider
{
    public function getId(): string { return 'rocket'; }
    public function getName(): string { return 'Rocket'; }
    public function getIcon(): string { return 'fas fa-university'; }
}
