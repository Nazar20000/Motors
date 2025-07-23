@extends('layout.app')

@section('title-block')
    Статистика
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@section('content')
<div class="admin-content">
    <h1>Статистика</h1>
    <ul>
        <li>Пользователей: 10</li>
        <li>Автомобилей: 5</li>
        <li>Заявок: 3</li>
    </ul>
</div>
@endsection 