<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @stack('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-block')</title>
</head>

<body>
    @include('include.header')

    @yield('content')
    
    @stack('scripts')

</body>
</html>
