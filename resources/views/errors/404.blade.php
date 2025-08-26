@extends('layout.app')

@section('title-block')
    Page Not Found - 404 Error
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
            <span class="material-symbols-outlined">search_off</span>
        </div>
        
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-description">
            The page you're looking for doesn't exist or has been moved.
        </p>
        
        <div class="error-details">
            <p>This could happen because:</p>
            <ul class="error-reasons">
                <li>The URL was typed incorrectly</li>
                <li>The page has been moved or deleted</li>
                <li>The link you followed is broken</li>
                <li>The page is temporarily unavailable</li>
            </ul>
        </div>
        
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <span class="material-symbols-outlined">home</span>
                Go Home
            </a>
            <a href="{{ route('inventory') }}" class="btn btn-secondary">
                <span class="material-symbols-outlined">directions_car</span>
                Browse Cars
            </a>
            <a href="{{ route('contact_us') }}" class="btn btn-outline">
                <span class="material-symbols-outlined">contact_support</span>
                Contact Us
            </a>
        </div>
        
        <div class="error-help">
            <p><strong>Looking for something specific?</strong> Try our search or browse our inventory.</p>
            <div class="search-suggestions">
                <a href="{{ route('car_finder') }}" class="suggestion-link">Car Finder</a>
                <a href="{{ route('about_us') }}" class="suggestion-link">About Us</a>
                <a href="{{ route('apply_online') }}" class="suggestion-link">Apply Online</a>
            </div>
        </div>
    </div>
</div>
@endsection 