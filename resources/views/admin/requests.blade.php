@extends('layout.app')

@section('title-block')
    Заявки
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@section('content')
<div class="admin-content">
    <h1>Заявки</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Сообщение</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <!-- Здесь будут заявки -->
            <tr>
                <td>1</td>
                <td>Иван</td>
                <td>ivan@example.com</td>
                <td>Хочу купить авто</td>
                <td>
                    <button>Просмотреть</button>
                    <button>Удалить</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection 