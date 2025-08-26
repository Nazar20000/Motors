<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!Auth::check()) {
                Log::warning('Unauthorized access attempt to admin area from IP: ' . $request->ip());
                return redirect('/login')->with('error', 'Please login to access the admin panel.');
            }

            // Check if user has admin role or is admin
            $user = Auth::user();
            
            // For now, we'll allow any authenticated user to access admin
            // In production, you should implement proper role checking
            Log::info('User accessing admin area: ' . $user->email . ' from IP: ' . $request->ip());
            
            return $next($request);
        } catch (\Exception $e) {
            Log::error('AdminMiddleware error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'An error occurred. Please try again.');
        }
    }
} 