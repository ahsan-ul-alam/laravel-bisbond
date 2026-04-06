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
     * Get health checks results.
     */
    public function check(): array
    {
        $results = [];

        // Check Business Name
        $results[] = $this->checkBusinessName();

        // Check Invoice Prefix
        $results[] = $this->checkInvoicePrefix();

        // Check SMS Config
        $results[] = $this->checkSmsConfig();

        // Check Payment Config
        $results[] = $this->checkPaymentConfig();

        return $results;
    }

    protected function checkBusinessName(): array
    {
        $name = $this->settings->get('general.business_name');

        if (!$name) {
            return [
                'status' => 'error',
                'title' => 'Missing Business Name',
                'message' => 'The business name is not set.',
                'suggestion' => 'Go to Wizard or Settings to update your business name.'
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'Business Name',
            'message' => 'Business name is properly configured.',
            'suggestion' => null
        ];
    }

    protected function checkInvoicePrefix(): array
    {
        if (!$this->settings->isModuleEnabled('invoice')) {
            return [
                'status' => 'warning',
                'title' => 'Invoice Module Disabled',
                'message' => 'The invoice module is currently disabled.',
                'suggestion' => 'Enable the invoice module in settings if needed.'
            ];
        }

        $prefix = $this->settings->get('invoice.prefix');

        if (!$prefix) {
            return [
                'status' => 'error',
                'title' => 'Missing Invoice Prefix',
                'message' => 'Invoice prefix is not configured.',
                'suggestion' => 'Set an invoice prefix like INV-'
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'Invoice Module',
            'message' => 'Invoice module is ready.',
            'suggestion' => null
        ];
    }

    protected function checkSmsConfig(): array
    {
        if (!$this->settings->isModuleEnabled('sms')) {
             return [
                'status' => 'warning',
                'title' => 'SMS Module Disabled',
                'message' => 'The SMS module is currently disabled.',
                'suggestion' => 'Enable the SMS module in settings if needed.'
            ];
        }

        $apiKey = $this->settings->get('sms.api_key');

        if (!$apiKey) {
            return [
                'status' => 'error',
                'title' => 'Missing SMS API Key',
                'message' => 'SMS API key is missing.',
                'suggestion' => 'Provide your SMS gateway API key in settings.'
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'SMS Gateway',
            'message' => 'SMS provider is configured.',
            'suggestion' => null
        ];
    }

    protected function checkPaymentConfig(): array
    {
        if (!$this->settings->isModuleEnabled('payments')) {
             return [
                'status' => 'warning',
                'title' => 'Payment Module Disabled',
                'message' => 'The payment module is currently disabled.',
                'suggestion' => 'Enable the payment module in settings if needed.'
            ];
        }

        $config = $this->settings->get('payments.gateway');

        if (!$config) {
            return [
                'status' => 'error',
                'title' => 'Missing Payment Config',
                'message' => 'Payment gateway is not configured.',
                'suggestion' => 'Configure your payment gateway (SSLCommerz, etc.)'
            ];
        }

        return [
            'status' => 'ok',
            'title' => 'Payments',
            'message' => 'Payment system is ready.',
            'suggestion' => null
        ];
    }
}
