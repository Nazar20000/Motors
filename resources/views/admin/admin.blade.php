@extends('layout.app')

@section('title-block')
    Админ панель
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@section('content')
<div class="admin-container">
    <nav class="admin-sidebar">
        <ul>
            <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Пользователи</a></li>
            <li><a href="{{ route('admin.cars') }}" class="{{ request()->routeIs('admin.cars') ? 'active' : '' }}">Автомобили</a></li>
            <li><a href="{{ route('admin.requests') }}" class="{{ request()->routeIs('admin.requests') ? 'active' : '' }}">Заявки</a></li>
            <li><a href="{{ route('admin.stats') }}" class="{{ request()->routeIs('admin.stats') ? 'active' : '' }}">Статистика</a></li>
            <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">Настройки</a></li>
        </ul>
    </nav>
    <section class="admin-content">
        <h1>Панель Администратора</h1>
        <p>Добро пожаловать в административную панель. Выберите раздел в меню слева.</p>
        <!-- Здесь будет динамический контент выбранного раздела -->
    </section>
</div>
@endsection

@push('scripts')
    <script src="/js/script.js"></script>
@endpush