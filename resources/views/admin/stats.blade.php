@extends('layout.admin')

@section('title-block')
    Statistics - Admin Panel
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-stats.css') }}">
@endpush

@section('content')
<div class="admin-container">
    <!-- Back Button -->
    <div class="admin-back-button">
        <a href="{{ route('admin.index') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Admin Panel
        </a>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Statistics</h1>
        </div>
        <div class="stats-header">
            <p>Overview of key system indicators</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $totalCars }}</div>
                <div class="stat-label">Total Cars</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">{{ $availableCars }}</div>
                <div class="stat-label">Available Cars</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">{{ $publishedCars }}</div>
                <div class="stat-label">Published Cars</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">{{ $totalBrands }}</div>
                <div class="stat-label">Brands in Catalog</div>
            </div>
        </div>
    </div>
</div>
@endsection 
