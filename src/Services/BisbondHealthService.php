<?php

namespace AhsanUlAlam\LaravelBisbond\Services;

class BisbondHealthService
{
    protected SettingService $settings;

    public function __construct(SettingService $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get a list of diagnostic health checks.
     */
    public function check(): array
    {
        return [
            $this->checkGeneral(),
            $this->checkInvoice(),
            $this->checkSMS(),
            $this->checkPayments(),
        ];
    }

    protected function checkGeneral(): array
    {
        $name = $this->settings->get('general.business_name');
        
        if (empty($name) || $name === 'Bisbond Business') {
            return [
                'status' => 'warning',
                'title' => 'Business Identity',
                'message' => 'Business name is still set to default or empty.',
                'suggestion' => 'Update your business name in General Settings.',
                'action_url' => route('bisbond.settings.index', ['group' => 'general'])
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'Business Identity',
            'message' => 'Configured as: ' . $name,
            'suggestion' => null,
            'action_url' => null
        ];
    }

    protected function checkInvoice(): array
    {
        if (!$this->settings->isModuleEnabled('invoice')) {
            return [
                'status' => 'warning',
                'title' => 'Invoice Module',
                'message' => 'The invoice module is currently disabled.',
                'suggestion' => 'Enable it in Module Settings if you need invoicing.',
                'action_url' => route('bisbond.settings.index', ['group' => 'modules'])
            ];
        }

        $prefix = $this->settings->get('invoice.prefix');
        if (empty($prefix)) {
            return [
                'status' => 'error',
                'title' => 'Invoice Config',
                'message' => 'Invoice prefix is missing.',
                'suggestion' => 'Set a prefix like "INV-" in Invoice Settings.',
                'action_url' => route('bisbond.settings.index', ['group' => 'invoice'])
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'Invoice Config',
            'message' => 'Module is ready with prefix: ' . $prefix,
            'suggestion' => null,
            'action_url' => null
        ];
    }

    protected function checkSMS(): array
    {
        if (!$this->settings->isModuleEnabled('sms')) {
            return [
                'status' => 'warning',
                'title' => 'SMS Gateway',
                'message' => 'SMS gateway is disabled.',
                'suggestion' => 'Enable it to manage SMS templates and providers.',
                'action_url' => route('bisbond.settings.index', ['group' => 'modules'])
            ];
        }

        $apiKey = $this->settings->get('sms.api_key');
        if (empty($apiKey)) {
            return [
                'status' => 'error',
                'title' => 'SMS Config',
                'message' => 'SMS API key/secret is not configured.',
                'suggestion' => 'Provide your gateway credentials in SMS Settings.',
                'action_url' => route('bisbond.settings.index', ['group' => 'sms'])
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'SMS Gateway',
            'message' => 'API Key is configured.',
            'suggestion' => null,
            'action_url' => null
        ];
    }

    protected function checkPayments(): array
    {
        if (!$this->settings->isModuleEnabled('payments')) {
             return [
                'status' => 'warning',
                'title' => 'Payment System',
                'message' => 'Payments are currently disabled.',
                'suggestion' => 'Enable the payment module to configure local gateways.',
                'action_url' => route('bisbond.settings.index', ['group' => 'modules'])
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'Payment System',
            'message' => 'Module is active and ready for configuration.',
            'suggestion' => null,
            'action_url' => null
        ];
    }
}
