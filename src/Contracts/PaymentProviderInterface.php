<?php

namespace AhsanUlAlam\LaravelBisbond\Contracts;

/**
 * Interface PaymentProviderInterface
 * Contract for all regional payment gateways.
 */
interface PaymentProviderInterface
{
    public function getId(): string;
    public function getName(): string;
    public function getIcon(): string;
    
    /**
     * Define the configuration fields needed for this provider.
     */
    public function getConfigFields(): array;

    /**
     * Get the current status (enabled/disabled) from settings.
     */
    public function isEnabled(): bool;

    /**
     * Get specific credential from settings.
     */
    public function getCredential(string $key, mixed $default = null): mixed;
}
