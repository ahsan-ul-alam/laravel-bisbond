<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use AhsanUlAlam\LaravelBisbond\Models\BisbondSetting;
use AhsanUlAlam\LaravelBisbond\Services\BisbondHealthService;
use AhsanUlAlam\LaravelBisbond\Services\SettingService;
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
        if (!$this->settings->get('wizard_completed')) {
            return redirect()->route('bisbond.wizard');
        }

        $healthChecks = $this->health->check();

        $stats = [
            'modules_enabled' => $this->getEnabledModulesCount(),
            'health_status' => $this->getOverallHealthStatus($healthChecks),
            'settings_count' => BisbondSetting::count(),
            'route_count' => $this->getRouteCount(),
            'command_count' => $this->getCommandCount(),
        ];

        $modules = [
            'formatter' => $this->settings->isModuleEnabled('formatter'),
            'invoice' => $this->settings->isModuleEnabled('invoice'),
            'sms' => $this->settings->isModuleEnabled('sms'),
            'payments' => $this->settings->isModuleEnabled('payments'),
        ];

        return view('bisbond::dashboard.index', compact('stats', 'modules', 'healthChecks'));
    }

    protected function getEnabledModulesCount(): int
    {
        $count = 0;
        $modules = ['formatter', 'invoice', 'sms', 'payments'];
        foreach ($modules as $module) {
            if ($this->settings->isModuleEnabled($module)) {
                $count++;
            }
        }
        return $count;
    }

    protected function getOverallHealthStatus(array $checks): string
    {
        $errors = 0;
        foreach ($checks as $check) {
            if ($check['status'] === 'error') {
                $errors++;
            }
        }

        return $errors > 0 ? 'Critical' : 'Healthy';
    }

    protected function getRouteCount(): int
    {
        return collect(Route::getRoutes())
            ->filter(fn($route) => str_starts_with($route->uri(), config('bisbond.route_prefix')))
            ->count();
    }

    protected function getCommandCount(): int
    {
        return count(array_filter(
            array_keys(Artisan::all()),
            fn($command) => str_starts_with($command, 'bisbond:')
        ));
    }
}
