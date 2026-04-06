<?php

namespace AhsanUlAlam\LaravelBisbond\Database\Seeders;

use AhsanUlAlam\LaravelBisbond\Models\BisbondSetting;
use Illuminate\Database\Seeder;

class BisbondSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Module Toggles
            ['key' => 'modules.formatter', 'value' => '1', 'group' => 'modules', 'type' => 'boolean'],
            ['key' => 'modules.invoice', 'value' => '1', 'group' => 'modules', 'type' => 'boolean'],
            ['key' => 'modules.sms', 'value' => '0', 'group' => 'modules', 'type' => 'boolean'],
            ['key' => 'modules.payments', 'value' => '0', 'group' => 'modules', 'type' => 'boolean'],

            // General Settings
            ['key' => 'general.business_name', 'value' => 'Bisbond Business', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.phone', 'value' => '', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.address', 'value' => '', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.currency', 'value' => 'BDT', 'group' => 'general', 'type' => 'string'],
            ['key' => 'general.locale', 'value' => 'bn', 'group' => 'general', 'type' => 'string'],

            // Formatter Settings
            ['key' => 'formatter.use_bangla_digits', 'value' => '1', 'group' => 'formatter', 'type' => 'boolean'],
            ['key' => 'formatter.currency_symbol', 'value' => '৳', 'group' => 'formatter', 'type' => 'string'],

            // Invoice Settings
            ['key' => 'invoice.prefix', 'value' => 'INV-', 'group' => 'invoice', 'type' => 'string'],
            ['key' => 'invoice.footer', 'value' => 'Thank you for your business.', 'group' => 'invoice', 'type' => 'string'],
            ['key' => 'invoice.logo', 'value' => '', 'group' => 'invoice', 'type' => 'string'],

            // SMS Settings
            ['key' => 'sms.provider', 'value' => 'infobip', 'group' => 'sms', 'type' => 'string'],
            ['key' => 'sms.sender_id', 'value' => 'BISBOND', 'group' => 'sms', 'type' => 'string'],
            ['key' => 'sms.api_key', 'value' => '', 'group' => 'sms', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            BisbondSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
