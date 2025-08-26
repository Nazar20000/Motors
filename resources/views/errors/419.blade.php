@extends('layout.app')

@section('title-block')
    Page Expired - CSRF Token Error
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
            <span class="material-symbols-outlined">security</span>
        </div>
        
        <h1 class="error-code">419</h1>
        <h2 class="error-title">Page Expired</h2>
        <p class="error-description">
            Your session has expired or the CSRF token is invalid. This usually happens when:
        </p>
        
        <ul class="error-reasons">
            <li>You've been inactive for too long</li>
            <li>The page was refreshed after being open for a while</li>
            <li>There was a security token mismatch</li>
            <li>Your browser cookies were cleared</li>
        </ul>
        
        <div class="error-actions">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <span class="material-symbols-outlined">arrow_back</span>
                Go Back
            </a>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">home</span>
                Go Home
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline">
                <span class="material-symbols-outlined">login</span>
                Login Again
            </a>
        </div>
        
        <div class="error-help">
            <p><strong>Need help?</strong> If this problem persists, please contact our support team.</p>
            <a href="{{ route('contact_us') }}" class="contact-link">Contact Support</a>
        </div>
    </div>
</div>
@endsection
