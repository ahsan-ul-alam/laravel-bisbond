<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

class SystemController extends Controller
{
    public function routes()
    {
        $routes = collect(Route::getRoutes())
            ->filter(fn($route) => str_starts_with($route->uri(), config('bisbond.route_prefix')))
            ->map(fn($route) => [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'example' => url($route->uri()),
            ])
            ->values();

        return view('bisbond::system.routes', compact('routes'));
    }

    public function commands()
    {
        $commands = collect(Artisan::all())
            ->map(fn($command, $name) => [
                'name' => $name,
                'description' => $command->getDescription(),
                'usage' => "php artisan {$name}",
            ])
            ->filter(fn($command) => str_starts_with($command['name'], 'bisbond:'))
            ->values();

        return view('bisbond::system.commands', compact('commands'));
    }
}
