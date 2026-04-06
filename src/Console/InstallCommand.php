<?php

namespace AhsanUlAlam\LaravelBisbond\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'bisbond:install';

    protected $description = 'Install Laravel Bisbond package';

    public function handle(): int
    {
        $this->info('Installing Laravel Bisbond...');

        $this->call('vendor:publish', ['--tag' => 'bisbond-config']);
        $this->call('migrate');

        $this->newLine();
        $this->info('Laravel Bisbond installed successfully.');
        $this->line('Open the dashboard at /' . config('bisbond.route_prefix'));

        return self::SUCCESS;
    }
}
