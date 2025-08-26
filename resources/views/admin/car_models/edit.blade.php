@extends('layout.admin')

@section('title-block')
    Edit Model
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
@endpush

@section('content')
<div class="admin-container">
    <!-- Back Button -->
    <div class="admin-back-button">
        <a href="{{ route('admin.car-models.index') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Models List
        </a>
    </div>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Edit Model</h1>
        </div>
    
    @if($errors->any())
        <div style="color: red; padding: 10px; background: #f8d7da; border-radius: 4px; margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form action="{{ route('admin.car-models.update', $carModel->id) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        
        <label>Name:
            <input type="text" name="name" value="{{ old('name', $carModel->name) }}" required>
        </label>
        
        <label>Brand:
            <select name="brand_id" required>
                <option value="">Select brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id', $carModel->brand_id) == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </label>
        
        <label><input type="checkbox" name="active" value="1" {{ old('active', $carModel->active) ? 'checked' : '' }}> Active</label>
        
        <button type="submit">Save</button>
    </form>
    
    <br>
    <a href="{{ route('admin.car-models.index') }}">Back to List</a>
</div>
@endsection 
