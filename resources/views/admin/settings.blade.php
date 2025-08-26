@extends('layout.admin')

@section('title-block')
    Settings - Admin Panel
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
        <div class="admin-header">
            <h1>Settings</h1>
        </div>
        <form>
            <label>Site Name: <input type="text" name="site_name" value="Motors"></label><br><br>
            <label>Contact Email: <input type="email" name="contact_email" value="admin@example.com"></label><br><br>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
@endsection 
