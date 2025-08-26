@extends('layout.app')

@section('title-block')
    Service Unavailable - 503 Error
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
            <span class="material-symbols-outlined">engineering</span>
        </div>
        
        <h1 class="error-code">503</h1>
        <h2 class="error-title">Service Unavailable</h2>
        <p class="error-description">
            We're temporarily unable to handle your request. We're working to restore service as quickly as possible.
        </p>
        
        <div class="error-details">
            <p>This could be due to:</p>
            <ul class="error-reasons">
                <li>Scheduled maintenance</li>
                <li>Server overload</li>
                <li>Database maintenance</li>
                <li>System updates</li>
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
            <p><strong>We apologize for the inconvenience.</strong> Please try again in a few minutes.</p>
            <p>For urgent matters, please contact our support team directly.</p>
            <div class="maintenance-info">
                <p>🔧 Estimated downtime: Usually 5-15 minutes</p>
                <p>📧 Emergency contact: support@dnbmotorsv.website</p>
            </div>
        </div>
    </div>
</div>
@endsection
