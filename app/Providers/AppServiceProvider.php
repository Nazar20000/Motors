<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // Register middleware
        Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        Route::aliasMiddleware('throttle', \App\Http\Middleware\ThrottleRequests::class);
        Route::aliasMiddleware('refresh.csrf', \App\Http\Middleware\RefreshCsrfToken::class);
        
        // Normalize session/cookie settings per request to prevent CSRF 419 due to domain/secure mismatch
        $isHttps = request()->secure() || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        $host = request()->getHost();
        
        // Adjust session cookie settings dynamically
        \Illuminate\Support\Facades\Config::set('session.secure', $isHttps);
        \Illuminate\Support\Facades\Config::set('session.same_site', 'lax');
        
        // If session domain is not set or mismatches current host, align it
        $configuredDomain = config('session.domain');
        if (empty($configuredDomain) || (!str_contains($host, (string) $configuredDomain) && !str_contains((string) $configuredDomain, $host))) {
            \Illuminate\Support\Facades\Config::set('session.domain', $host);
        }
        
        // Production optimizations
        if (app()->environment('production')) {
            // Force HTTPS in production, trusting proxy headers
            if ($isHttps) {
                \URL::forceScheme('https');
            }
            
            // Optimize for production
            \Illuminate\Support\Facades\Config::set('app.debug', false);
            \Illuminate\Support\Facades\Config::set('app.env', 'production');
        }
    }
}
