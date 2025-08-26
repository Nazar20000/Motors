@extends('layout.app')

@section('title-block')
    Body Types
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-forms.css') }}">
@endpush

@section('content')
<div class="admin-content">
    <!-- Back Button and Header -->
    <div class="admin-header">
        <a href="{{ route('admin.index') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Admin Panel
        </a>
        <h1>Body Types</h1>
    </div>
    <a href="{{ route('admin.body-types.create') }}" class="btn btn-primary" style="margin-bottom: 20px; display: inline-block;">Add Body Type</a>
    
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
            @foreach($bodyTypes as $bodyType)
            <tr>
                <td>{{ $bodyType->id }}</td>
                <td>{{ $bodyType->name }}</td>
                <td>{{ $bodyType->slug }}</td>
                <td>
                    <span class="status-badge {{ $bodyType->active ? 'status-active' : 'status-inactive' }}">
                        {{ $bodyType->active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $bodyType->cars->count() }}</td>
                <td class="action-buttons">
                    <a href="{{ route('admin.body-types.edit', $bodyType->id) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('admin.body-types.destroy', $bodyType->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination">
        {{ $bodyTypes->links() }}
    </div>
</div>
@endsection 
