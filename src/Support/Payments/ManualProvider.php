<?php

namespace AhsanUlAlam\LaravelBisbond\Support\Payments;

class ManualProvider extends BasePaymentProvider
{
    public function getId(): string { return 'manual'; }
    public function getName(): string { return 'Manual Payment'; }
    public function getIcon(): string { return 'fas fa-hand-holding-usd'; }
    public function getConfigFields(): array { return ['instructions']; }
}
