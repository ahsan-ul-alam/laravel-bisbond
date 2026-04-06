<?php

use AhsanUlAlam\LaravelBisbond\Http\Controllers\DashboardController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\SettingsController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\SystemController;
use AhsanUlAlam\LaravelBisbond\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

if (config('bisbond.dashboard.enabled', true)) {
    Route::prefix(config('bisbond.route_prefix', 'bisbond'))
        ->middleware(config('bisbond.route_middleware', ['web']))
        ->group(function () {
            
            // Dashboard & Guide
            Route::get('/', [DashboardController::class, 'index'])->name('bisbond.dashboard');
            Route::get('/guide', [DashboardController::class, 'guide'])->name('bisbond.guide');
            
            // Settings Console
            Route::get('/settings', [SettingsController::class, 'index'])->name('bisbond.settings.index');
            Route::post('/settings', [SettingsController::class, 'update'])->name('bisbond.settings.update');
            
            // System Explorer
            Route::get('/system/routes', [SystemController::class, 'routes'])->name('bisbond.system.routes');
            Route::get('/system/commands', [SystemController::class, 'commands'])->name('bisbond.system.commands');

            // Module Features
            Route::middleware('bisbond.module:invoice')->group(function () {
                Route::get('/invoice/preview', [InvoiceController::class, 'preview'])->name('bisbond.invoice.preview');
            });
        });
}
