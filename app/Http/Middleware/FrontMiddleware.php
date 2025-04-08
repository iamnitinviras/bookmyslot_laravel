<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = Settings::pluck('value', 'title')->toArray();
        config(['seo_keyword' => $settings['seo_keyword'] ?? ""]);
        config(['seo_description' => $settings['seo_description'] ?? ""]);
        config(['analytics_code' => $settings['analytics_code'] ?? ""]);
        return $next($request);
    }
}
