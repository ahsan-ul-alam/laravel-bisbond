<?php

namespace AhsanUlAlam\LaravelBisbond;

use AhsanUlAlam\LaravelBisbond\Console\InstallCommand;
use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use AhsanUlAlam\LaravelBisbond\Services\BisbondHealthService;
use AhsanUlAlam\LaravelBisbond\Services\PaymentProviderManager;
use AhsanUlAlam\LaravelBisbond\Http\Middleware\CheckModuleEnabled;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class LaravelBisbondServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bisbond.php', 'bisbond');

        // Register SettingService as a singleton to maintain memory map
        $this->app->singleton(SettingService::class, function () {
            return new SettingService();
        });

        // Register HealthService
        $this->app->singleton(BisbondHealthService::class, function ($app) {
            return new BisbondHealthService($app->make(SettingService::class));
        });

        // Register Payment Manager
        $this->app->singleton(PaymentProviderManager::class, function () {
            return new PaymentProviderManager();
        });
    }

    public function boot(Router $router): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bisbond');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Register Middleware alias
        $router->aliasMiddleware('bisbond.module', CheckModuleEnabled::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/bisbond.php' => config_path('bisbond.php'),
            ], 'bisbond-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/bisbond'),
            ], 'bisbond-views');

            $this->commands([
                InstallCommand::class,
            ]);
        }

        // Auto-load helpers
        if (file_exists($helperPath = __DIR__ . '/Helpers/helpers.php')) {
            require_once $helperPath;
        }
    }
}
