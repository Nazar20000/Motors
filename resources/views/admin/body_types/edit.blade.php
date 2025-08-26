@extends('layout.admin')

@section('title-block')
    Edit Body Type
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
@endpush

@section('content')
<div class="admin-container">
    <!-- Back Button -->
    <div class="admin-back-button">
        <a href="{{ route('admin.body-types.index') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Body Types List
        </a>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Edit Body Type</h1>
        </div>
    
    @if($errors->any())
        <div style="color: red; padding: 10px; background: #f8d7da; border-radius: 4px; margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form action="{{ route('admin.body-types.update', $bodyType->id) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        
        <label>Name:
            <input type="text" name="name" value="{{ old('name', $bodyType->name) }}" required>
        </label>
        
        <label><input type="checkbox" name="active" value="1" {{ old('active', $bodyType->active) ? 'checked' : '' }}> Active</label>
        
        <button type="submit">Save</button>
    </form>
    
    <br>
    <a href="{{ route('admin.body-types.index') }}">Back to List</a>
</div>
@endsection 
