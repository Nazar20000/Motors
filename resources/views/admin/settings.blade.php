@extends('layout.app')

@section('title-block')
    Настройки
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@section('content')
<div class="admin-content">
    <h1>Настройки</h1>
    <form>
        <label>Название сайта: <input type="text" name="site_name" value="Motors"></label><br><br>
        <label>Email для связи: <input type="email" name="contact_email" value="admin@example.com"></label><br><br>
        <button type="submit">Сохранить</button>
    </form>
</div>
@endsection 