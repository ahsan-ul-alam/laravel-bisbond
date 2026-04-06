<?php

namespace AhsanUlAlam\LaravelBisbond;

use AhsanUlAlam\LaravelBisbond\Console\InstallCommand;
use AhsanUlAlam\LaravelBisbond\Services\BisbondManager;
use Illuminate\Support\ServiceProvider;

class LaravelBisbondServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bisbond.php', 'bisbond');

        $this->app->singleton('bisbond', function () {
            return new Services\BisbondManager();
        });

        $this->app->singleton(Services\SettingService::class, function () {
            return new Services\SettingService();
        });

        $this->app->singleton(Services\BisbondHealthService::class, function ($app) {
            return new Services\BisbondHealthService($app->make(Services\SettingService::class));
        });
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bisbond');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

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
    }
}
