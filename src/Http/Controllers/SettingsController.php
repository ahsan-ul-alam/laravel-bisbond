<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    protected SettingService $settings;

    public function __construct(SettingService $settings)
    {
        $this->settings = $settings;
    }

    public function index()
    {
        $settings = $this->settings->all();
        
        $modules = [
            'formatter' => $this->settings->isModuleEnabled('formatter'),
            'invoice' => $this->settings->isModuleEnabled('invoice'),
            'sms' => $this->settings->isModuleEnabled('sms'),
            'payments' => $this->settings->isModuleEnabled('payments'),
        ];

        return view('bisbond::settings.index', compact('settings', 'modules'));
    }

    public function update(Request $request)
    {
        if ($request->has('modules')) {
            foreach ($request->input('modules') as $module => $enabled) {
                $this->settings->set("modules.$module", (bool) $enabled, 'modules', 'boolean');
            }
        }

        if ($request->has('settings')) {
            foreach ($request->input('settings') as $key => $value) {
                $group = str($key)->before('.')->value() ?: 'general';
                $this->settings->set($key, $value, $group);
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
