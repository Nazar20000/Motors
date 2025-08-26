@extends('layout.admin')

@section('title-block')
    Car Models - Admin Panel
@endsection

@push('styles')
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
