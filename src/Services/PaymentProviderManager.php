<?php

namespace AhsanUlAlam\LaravelBisbond\Services;

use AhsanUlAlam\LaravelBisbond\Contracts\PaymentProviderInterface;
use AhsanUlAlam\LaravelBisbond\Support\Payments\BkashProvider;
use AhsanUlAlam\LaravelBisbond\Support\Payments\NagadProvider;
use AhsanUlAlam\LaravelBisbond\Support\Payments\RocketProvider;
use AhsanUlAlam\LaravelBisbond\Support\Payments\SslCommerzProvider;
use AhsanUlAlam\LaravelBisbond\Support\Payments\ManualProvider;
use Illuminate\Support\Collection;

class PaymentProviderManager
{
    protected array $providers = [];

    public function __construct()
    {
        $this->registerDefaultProviders();
    }

    /**
     * Register a new payment provider.
     */
    public function register(PaymentProviderInterface $provider): void
    {
        $this->providers[$provider->getId()] = $provider;
    }

    /**
     * Get all registered providers.
     */
    public function all(): Collection
    {
        return collect($this->providers);
    }

    /**
     * Get a specific provider by ID.
     */
    public function get(string $id): ?PaymentProviderInterface
    {
        return $this->providers[$id] ?? null;
    }

    /**
     * Register default regional providers.
     */
    protected function registerDefaultProviders(): void
    {
        $this->register(new BkashProvider());
        $this->register(new NagadProvider());
        $this->register(new RocketProvider());
        $this->register(new SslCommerzProvider());
        $this->register(new ManualProvider());
    }
}
