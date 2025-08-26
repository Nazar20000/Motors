<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    
    <link rel="icon" href="/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.2">
    @stack('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-block', 'D.N B Motors V')</title>
</head>

<body>
    @include('include.header')

    @yield('content')
    
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/csrf-refresh.js') }}"></script>
    @stack('scripts')
@include('include.footer')
</body>
</html>
