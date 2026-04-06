<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WizardController extends Controller
{
    protected SettingService $settings;

    public function __construct(SettingService $settings)
    {
        $this->settings = $settings;
    }

    public function index()
    {
        if ($this->settings->get('wizard_completed')) {
            return redirect()->route('bisbond.dashboard');
        }

        return view('bisbond::wizard.index');
    }

    public function store(Request $request)
    {
        $step = $request->input('step');

        switch ($step) {
            case 1:
                $this->settings->setMany([
                    'general.business_name' => $request->business_name,
                    'general.phone' => $request->phone,
                    'general.currency' => $request->currency,
                ], 'general');
                break;

            case 2:
                $this->settings->setMany([
                    'invoice.prefix' => $request->invoice_prefix,
                    'invoice.footer' => $request->invoice_footer,
                    'invoice.logo' => $request->invoice_logo,
                ], 'invoice');
                break;

            case 3:
                $this->settings->setMany([
                    'sms.provider' => $request->sms_provider,
                    'sms.api_key' => $request->sms_api_key,
                    'sms.sender_id' => $request->sms_sender_id,
                ], 'sms');
                break;

            case 'finish':
                $this->settings->set('wizard_completed', true, 'system', 'boolean');
                return response()->json(['success' => true]);
        }

        return response()->json(['success' => true]);
    }
}
