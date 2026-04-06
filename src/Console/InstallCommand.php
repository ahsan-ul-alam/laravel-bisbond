<?php

namespace AhsanUlAlam\LaravelBisbond\Console;

use AhsanUlAlam\LaravelBisbond\Database\Seeders\BisbondSettingSeeder;
use AhsanUlAlam\LaravelBisbond\Services\SettingService;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'bisbond:install';
    protected $description = 'Initialize the Laravel Bisbond regional toolkit';

    public function handle(SettingService $settings)
    {
        $this->info('🚀 Starting Bisbond Installation...');

        $this->comment('Publishing package assets...');
        $this->call('vendor:publish', [
            '--provider' => "AhsanUlAlam\LaravelBisbond\LaravelBisbondServiceProvider",
            '--tag'      => 'bisbond-config'
        ]);

        $this->comment('Running migrations...');
        $this->call('migrate');

        $this->comment('Seeding default toolkit settings...');
        $seeder = new BisbondSettingSeeder();
        $seeder->run();

        $this->comment('Refreshing settings cache...');
        $settings->refresh();

        $this->info('✅ Bisbond toolkit installed successfully!');
        
        $prefix = config('bisbond.route_prefix', 'bisbond');
        $url = url($prefix);
        
        $this->line('');
        $this->line("📍 Access your Control Center at: <info>$url</info>");
        $this->line('');
    }
}
