<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use AhsanUlAlam\LaravelBisbond\Models\BisbondSetting;
use AhsanUlAlam\LaravelBisbond\Services\BisbondHealthService;
use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use AhsanUlAlam\LaravelBisbond\Services\PaymentProviderManager;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    protected SettingService $settings;
    protected BisbondHealthService $health;

    public function __construct(SettingService $settings, BisbondHealthService $health)
    {
        $this->settings = $settings;
        $this->health = $health;
    }

    public function index()
    {
        $healthChecks = $this->health->check();
        
        $issueCount = collect($healthChecks)->whereIn('status', ['error', 'warning'])->count();

        $stats = [
            'modules_enabled' => $this->getEnabledModulesCount(),
            'health_status'   => $this->getOverallHealthStatus($healthChecks),
            'issue_count'     => $issueCount,
            'settings_count'  => BisbondSetting::count(),
            'route_count'     => $this->getRouteCount(),
            'command_count'   => $this->getCommandCount(),
        ];

        $modules = [
            'formatter' => $this->settings->isModuleEnabled('formatter'),
            'invoice'   => $this->settings->isModuleEnabled('invoice'),
            'sms'       => $this->settings->isModuleEnabled('sms'),
            'payments'  => $this->settings->isModuleEnabled('payments'),
        ];

        $paymentProviders = app(PaymentProviderManager::class)->all();

        return view('bisbond::dashboard.index', compact('stats', 'modules', 'healthChecks', 'paymentProviders'));
    }

    /**
     * Display the Developer Integration Guide.
     */
    public function guide()
    {
        return view('bisbond::dashboard.guide');
    }

    protected function getEnabledModulesCount(): int
    {
        $count = 0;
        foreach (['formatter', 'invoice', 'sms', 'payments'] as $module) {
            if ($this->settings->isModuleEnabled($module)) $count++;
        }
        return $count;
    }

    protected function getOverallHealthStatus(array $checks): string
    {
        foreach ($checks as $check) {
            if ($check['status'] === 'error') return 'Critical';
        }
        return 'Healthy';
    }

    protected function getRouteCount(): int
    {
        $prefix = config('bisbond.route_prefix', 'bisbond');
        return collect(Route::getRoutes())
            ->filter(fn($r) => str_starts_with($r->uri(), $prefix))
            ->count();
    }

    protected function getCommandCount(): int
    {
        return count(array_filter(
            array_keys(Artisan::all()),
            fn($cmd) => str_starts_with($cmd, 'bisbond:')
        ));
    }
}
