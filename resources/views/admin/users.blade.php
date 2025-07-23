@extends('layout.app')

@section('title-block')
    Пользователи
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@section('content')
<div class="admin-content">
    <h1>Пользователи</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <!-- Здесь будут пользователи -->
            <tr>
                <td>1</td>
                <td>Admin</td>
                <td>admin@example.com</td>
                <td>
                    <button>Редактировать</button>
                    <button>Удалить</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection 