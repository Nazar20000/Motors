@extends('layout.app')

@section('title-block')
    Error - Something Went Wrong
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
            <span class="material-symbols-outlined">warning</span>
        </div>
        
        <h1 class="error-code">{{ $exception->getStatusCode() ?? 'Error' }}</h1>
        <h2 class="error-title">Something Went Wrong</h2>
        <p class="error-description">
            An unexpected error occurred. Our team has been notified and is investigating the issue.
        </p>
        
        <div class="error-details">
            <p>What you can do:</p>
            <ul class="error-reasons">
                <li>Try refreshing the page</li>
                <li>Go back to the previous page</li>
                <li>Navigate to our homepage</li>
                <li>Contact our support team</li>
            </ul>
        </div>
        
        <div class="error-actions">
            <button onclick="window.location.reload()" class="btn btn-primary">
                <span class="material-symbols-outlined">refresh</span>
                Refresh Page
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
            <p><strong>Need immediate assistance?</strong> Our support team is here to help.</p>
            <p>Please include the error code above when contacting support.</p>
        </div>
    </div>
</div>
@endsection
