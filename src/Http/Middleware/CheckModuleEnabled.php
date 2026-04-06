<?php

namespace AhsanUlAlam\LaravelBisbond\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleEnabled
{
    /**
     * Handle an incoming request.
     * Redirects to dashboard if the requested module is disabled.
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (!bisbond_module($module)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => "The $module module is currently disabled."], 403);
            }

            return redirect()->route('bisbond.dashboard')
                ->with('error', "The " . ucfirst($module) . " module is currently disabled. Enable it in settings to access this feature.");
        }

        return $next($request);
    }
}
