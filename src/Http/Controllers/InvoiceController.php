<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use AhsanUlAlam\LaravelBisbond\Support\BanglaFormatter;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    protected SettingService $settings;

    public function __construct(SettingService $settings)
    {
        $this->settings = $settings;
    }

    public function preview()
    {
        $formatter = new BanglaFormatter();
        $amount = 1500;

        $invoice = [
            'business_name' => $this->settings->get('general.business_name', 'My Business'),
            'prefix'        => $this->settings->get('invoice.prefix', 'INV-'),
            'number'        => '001',
            'amount'        => $amount,
            'amount_bn'     => $formatter->toBangla($amount),
            'amount_money'  => $formatter->money($amount),
            'currency'      => $this->settings->get('general.currency', 'BDT'),
            'footer'        => $this->settings->get('invoice.footer', 'Thank you for your business!'),
            'date'          => now()->format('Y-m-d'),
            'date_bn'       => $formatter->date(now()),
        ];

        return view('bisbond::invoice.preview', compact('invoice'));
    }
}
