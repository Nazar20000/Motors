<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle CSRF token mismatch (419 error)
        $this->renderable(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'CSRF token mismatch.',
                    'error' => 'token_mismatch'
                ], 419);
            }

            return response()->view('errors.419', [], 419);
        });

        // Handle authentication exceptions (401 error)
        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'error' => 'unauthenticated'
                ], 401);
            }

            return response()->view('errors.401', [], 401);
        });

        // Handle authorization exceptions (403 error)
        $this->renderable(function (AuthorizationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'This action is unauthorized.',
                    'error' => 'unauthorized'
                ], 403);
            }

            return response()->view('errors.403', [], 403);
        });

        // Handle model not found exceptions (404 error)
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Resource not found.',
                    'error' => 'not_found'
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        // Handle HTTP exceptions
        $this->renderable(function (HttpException $e, Request $request) {
            $statusCode = $e->getStatusCode();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'error' => 'http_exception'
                ], $statusCode);
            }

            // Map specific status codes to custom error views
            switch ($statusCode) {
                case 404:
                    return response()->view('errors.404', [], 404);
                case 403:
                    return response()->view('errors.403', [], 403);
                case 401:
                    return response()->view('errors.401', [], 401);
                case 429:
                    return response()->view('errors.429', [], 429);
                case 503:
                    return response()->view('errors.503', [], 503);
                case 500:
                    return response()->view('errors.500', [], 500);
                default:
                    return response()->view('errors.generic', ['exception' => $e], $statusCode);
            }
        });

        // Handle too many requests (429 error)
        $this->renderable(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Too many requests.',
                    'error' => 'too_many_requests'
                ], 429);
            }

            return response()->view('errors.429', [], 429);
        });

        // Handle validation exceptions
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $e->errors(),
                ], 422);
            }

            // For web requests, let Laravel handle validation errors normally
            return null;
        });
    }
} 