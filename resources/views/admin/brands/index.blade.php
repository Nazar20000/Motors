@extends('layout.admin')

@section('title-block')
    Brands - Admin Panel
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
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
        <h1>Brands</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary" style="margin-bottom: 20px; display: inline-block;">Add Brand</a>
        
        @if(session('success'))
            <div style="color: green; padding: 10px; background: #d4edda; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div style="color: red; padding: 10px; background: #f8d7da; border-radius: 4px; margin-bottom: 20px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Cars Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->slug }}</td>
                    <td>
                        <span class="status-badge {{ $brand->active ? 'status-active' : 'status-inactive' }}">
                            {{ $brand->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $brand->cars->count() }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="pagination">
            {{ $brands->links() }}
        </div>
    </div>
</div>
@endsection 
