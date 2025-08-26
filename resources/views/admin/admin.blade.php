@extends('layout.admin')

@section('title-block')
    Admin Panel
@endsection

@push('styles')
@endpush

@section('content')
<div class="admin-container">
    <!-- Admin Top Bar -->
    <div class="admin-top-bar">
        <h1>Administrator Panel</h1>
        <div class="admin-actions">
            <a href="{{ route('home') }}" class="back-to-site">
                <span class="material-symbols-outlined">home</span>
                Back to Site
            </a>
        </div>
    </div>
    
    <nav class="admin-sidebar">
        <ul>
            <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Users</a></li>
            <li><a href="{{ route('admin.cars') }}" class="{{ request()->routeIs('admin.cars') ? 'active' : '' }}">Cars</a></li>
            <li><a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">Brands</a></li>
            <li><a href="{{ route('admin.car-models.index') }}" class="{{ request()->routeIs('admin.car-models.*') ? 'active' : '' }}">Models</a></li>
            <li><a href="{{ route('admin.body-types.index') }}" class="{{ request()->routeIs('admin.body-types.*') ? 'active' : '' }}">Body Types</a></li>
            <li><a href="{{ route('admin.requests') }}" class="{{ request()->routeIs('admin.requests') ? 'active' : '' }}">Requests</a></li>
            <li><a href="{{ route('admin.applications') }}" class="{{ request()->routeIs('admin.applications*') ? 'active' : '' }}">Applications</a></li>
            <li><a href="{{ route('admin.stats') }}" class="{{ request()->routeIs('admin.stats') ? 'active' : '' }}">Statistics</a></li>
            <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">Settings</a></li>
        </ul>
    </nav>
    
    <section class="admin-content">
        <h2>Welcome to the administrative panel</h2>
        <p>Select a section from the menu on the left to manage your website content.</p>
        <!-- Dynamic content of the selected section will be here -->
    </section>
</div>
@endsection

@push('scripts')
@endpush
