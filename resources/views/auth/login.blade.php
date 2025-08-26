@extends('layout.app')

@section('title-block')
    Login
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="auth-container">
    <h2>Login</h2>
    
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form class="auth-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="remember-me">
            <label>
                <input type="checkbox" name="remember" id="remember">
                <span>Remember me</span>
            </label>
        </div>
        
        <button type="submit">Login</button>
    </form>
    
    <div class="auth-links">
        <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </div>
</div>
@endsection 
