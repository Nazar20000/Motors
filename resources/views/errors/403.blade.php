@extends('layout.app')

@section('title-block')
    Access Forbidden - 403 Error
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
            <span class="material-symbols-outlined">block</span>
        </div>
        
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Access Forbidden</h2>
        <p class="error-description">
            You don't have permission to access this resource. This area is restricted.
        </p>
        
        <div class="error-details">
            <p>This could happen because:</p>
            <ul class="error-reasons">
                <li>You're not logged in</li>
                <li>Your account doesn't have the required permissions</li>
                <li>This is an admin-only area</li>
                <li>Your session has expired</li>
            </ul>
        </div>
        
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">home</span>
                Go Home
            </a>
            <a href="{{ route('login') }}" class="btn btn-secondary">
                <span class="material-symbols-outlined">login</span>
                Login
            </a>
            <a href="{{ route('contact_us') }}" class="btn btn-outline">
                <span class="material-symbols-outlined">contact_support</span>
                Contact Support
            </a>
        </div>
        
        <div class="error-help">
            <p><strong>Need access?</strong> Contact our team to request the necessary permissions.</p>
            <p>If you believe this is an error, please let us know.</p>
        </div>
    </div>
</div>
@endsection
