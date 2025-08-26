@extends('layout.app')

@section('title-block')
    Server Error - Internal Server Error
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
            <span class="material-symbols-outlined">error</span>
        </div>
        
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Internal Server Error</h2>
        <p class="error-description">
            Something went wrong on our end. Our team has been notified and is working to fix the issue.
        </p>
        
        <div class="error-details">
            <p>This error typically occurs due to:</p>
            <ul class="error-reasons">
                <li>Database connection issues</li>
                <li>Server configuration problems</li>
                <li>Application code errors</li>
                <li>Resource limitations</li>
            </ul>
        </div>
        
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">home</span>
                Go Home
            </a>
            <button onclick="window.location.reload()" class="btn btn-secondary">
                <span class="material-symbols-outlined">refresh</span>
                Try Again
            </button>
            <a href="{{ route('contact_us') }}" class="btn btn-outline">
                <span class="material-symbols-outlined">support_agent</span>
                Report Issue
            </a>
        </div>
        
        <div class="error-help">
            <p><strong>We're sorry for the inconvenience.</strong> Please try again in a few minutes.</p>
            <p>If the problem persists, please contact our technical support team.</p>
        </div>
    </div>
</div>
@endsection 