<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

class SystemController extends Controller
{
    /**
     * Display package-specific routes with metadata.
     */
    public function routes()
    {
        $prefix = config('bisbond.route_prefix', 'bisbond');
        
        $routes = collect(Route::getRoutes())
            ->filter(fn($route) => str_starts_with($route->uri(), $prefix))
            ->map(fn($route) => [
                'method' => implode('|', $route->methods()),
                'uri'    => $route->uri(),
                'name'   => $route->getName(),
                'action' => $route->getActionName(),
            ])
            ->values();

        return view('bisbond::system.routes', compact('routes'));
    }

    /**
     * Display package-specific commands with usage hints.
     */
    public function commands()
    {
        $commands = collect(Artisan::all())
            ->filter(fn($cmd, $name) => str_starts_with($name, 'bisbond:'))
            ->map(fn($cmd, $name) => [
                'name'        => $name,
                'description' => $cmd->getDescription(),
                'usage'       => "php artisan $name",
            ])
            ->values();

        return view('bisbond::system.commands', compact('commands'));
    }
}
