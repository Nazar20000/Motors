@extends('layout.app')

@section('title-block')
    Автомобили
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
@endpush

@section('content')
<div class="admin-content">
    <h1>Автомобили</h1>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary" style="margin-bottom: 20px; display: inline-block;">Добавить автомобиль</a>
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Год</th>
                <th>Цена</th>
                <th>Описание</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
            <tr>
                <td>{{ $car->id }}</td>
                <td>{{ $car->brand }}</td>
                <td>{{ $car->model }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ $car->price }}</td>
                <td>{{ $car->description }}</td>
                <td>
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="car" width="80">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.cars.edit', $car->id) }}">Редактировать</a>
                    <form action="{{ route('admin.cars.delete', $car->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить автомобиль?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 