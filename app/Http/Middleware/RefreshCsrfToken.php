<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RefreshCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // NOTE: Do not refresh token during POST requests to avoid token mismatch
        $lastRefresh = Session::get('csrf_last_refresh', 0);
        $currentTime = time();
        
        if ($request->isMethod('get') && ($currentTime - $lastRefresh > 1800)) { // only on GET
            Session::regenerateToken();
            Session::put('csrf_last_refresh', $currentTime);
        }
        
        return $next($request);
    }
}
