<?php

use AhsanUlAlam\LaravelBisbond\Http\Controllers\DashboardController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\SettingsController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\SystemController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\WizardController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

if (config('bisbond.dashboard.enabled')) {
    Route::prefix(config('bisbond.route_prefix'))
        ->middleware(config('bisbond.route_middleware', ['web']))
        ->group(function () {
            // Wizard
            Route::get('/wizard', [WizardController::class, 'index'])->name('bisbond.wizard');
            Route::post('/wizard', [WizardController::class, 'store'])->name('bisbond.wizard.store');

            // Dashboard
            Route::get('/', [DashboardController::class, 'index'])->name('bisbond.dashboard');
            
            // Settings
            Route::get('/settings', [SettingsController::class, 'index'])->name('bisbond.settings.index');
            Route::post('/settings', [SettingsController::class, 'update'])->name('bisbond.settings.update');
            
            // System Explorer
            Route::get('/system/routes', [SystemController::class, 'routes'])->name('bisbond.system.routes');
            Route::get('/system/commands', [SystemController::class, 'commands'])->name('bisbond.system.commands');

            // Invoice Preview
            Route::get('/invoice/preview', [InvoiceController::class, 'preview'])->name('bisbond.invoice.preview');
        });
}
