<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    @stack('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-block')</title>
</head>

<body>
    @include('include.header')

    @yield('content')
    
    @stack('scripts')
@include('include.footer')
</body>
</html>
