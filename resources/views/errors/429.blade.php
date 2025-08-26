@extends('layout.app')

@section('title-block')
    Too Many Requests - 429 Error
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="error-container">
    <div class="error-content">
        <div class="error-icon">
            <span class="material-symbols-outlined">speed</span>
        </div>
        
        <h1 class="error-code">429</h1>
        <h2 class="error-title">Too Many Requests</h2>
        <p class="error-description">
            You've made too many requests in a short time. Please wait a moment before trying again.
        </p>
        
        <div class="error-details">
            <p>This rate limiting helps us:</p>
            <ul class="error-reasons">
                <li>Prevent abuse and spam</li>
                <li>Ensure fair usage for all users</li>
                <li>Maintain server performance</li>
                <li>Protect against automated attacks</li>
            </ul>
        </div>
        
        <div class="error-actions">
            <button onclick="window.location.reload()" class="btn btn-primary">
                <span class="material-symbols-outlined">refresh</span>
                Try Again
            </button>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <span class="material-symbols-outlined">home</span>
                Go Home
            </a>
            <a href="{{ route('contact_us') }}" class="btn btn-outline">
                <span class="material-symbols-outlined">contact_support</span>
                Contact Support
            </a>
        </div>
        
        <div class="error-help">
            <p><strong>Please wait a few minutes</strong> before making another request.</p>
            <p>If you need immediate assistance, please contact our support team.</p>
            <div class="countdown-info">
                <p>⏱️ Rate limit resets automatically</p>
            </div>
        </div>
    </div>
</div>
@endsection
