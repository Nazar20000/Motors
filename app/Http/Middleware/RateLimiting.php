<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RateLimiting
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $limiter = 'default'): Response
    {
        $key = $this->resolveRequestSignature($request);
        
        if (RateLimiter::tooManyAttempts($key, $this->getMaxAttempts($limiter))) {
            Log::warning('Rate limit exceeded', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->url(),
                'limiter' => $limiter
            ]);
            
            return response()->json([
                'error' => 'Too many requests. Please try again later.',
                'retry_after' => RateLimiter::availableIn($key)
            ], 429);
        }
        
        RateLimiter::hit($key, $this->getDecayMinutes($limiter) * 60);
        
        $response = $next($request);
        
        return $response->header('X-RateLimit-Limit', $this->getMaxAttempts($limiter))
                       ->header('X-RateLimit-Remaining', RateLimiter::remaining($key, $this->getMaxAttempts($limiter)));
    }
    
    /**
     * Resolve request signature.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        return sha1(implode('|', [
            $request->ip(),
            $request->userAgent(),
            $request->user()?->id ?? 'guest'
        ]));
    }
    
    /**
     * Get max attempts for limiter.
     */
    protected function getMaxAttempts(string $limiter): int
    {
        return match($limiter) {
            'api' => 60,
            'auth' => 5,
            'search' => 30,
            default => 100
        };
    }
    
    /**
     * Get decay minutes for limiter.
     */
    protected function getDecayMinutes(string $limiter): int
    {
        return match($limiter) {
            'api' => 1,
            'auth' => 15,
            'search' => 1,
            default => 1
        };
    }
} 