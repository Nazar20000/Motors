@extends('layout.app')

@section('title-block')
    Unauthorized Access - 401 Error
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
            <span class="material-symbols-outlined">lock</span>
        </div>
        
        <h1 class="error-code">401</h1>
        <h2 class="error-title">Unauthorized Access</h2>
        <p class="error-description">
            You need to be authenticated to access this resource. Please log in to continue.
        </p>
        
        <div class="error-details">
            <p>This typically means:</p>
            <ul class="error-reasons">
                <li>You're not logged in to your account</li>
                <li>Your login session has expired</li>
                <li>You need to provide valid credentials</li>
                <li>This is a protected area requiring authentication</li>
            </ul>
        </div>
        
        <div class="error-actions">
            <a href="{{ route('login') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">login</span>
                Login Now
            </a>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                <span class="material-symbols-outlined">person_add</span>
                Create Account
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline">
                <span class="material-symbols-outlined">home</span>
                Go Home
            </a>
        </div>
        
        <div class="error-help">
            <p><strong>Don't have an account?</strong> You can create one for free to access our services.</p>
            <p>Having trouble logging in? <a href="{{ route('contact_us') }}" class="contact-link">Contact our support team</a>.</p>
        </div>
    </div>
</div>
@endsection
