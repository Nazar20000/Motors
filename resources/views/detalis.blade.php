@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./css/vehicle-detail.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<main class="car-details-page">
    <div class="container">
        <div class="car-details-layout">
            <div class="car-main-photo">
                @if($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}" alt="Главное фото" style="max-width:400px; border-radius:10px;">
                @endif
            </div>
            <div class="car-info">
                <h1>{{ $car->year }} {{ $car->brand }} {{ $car->model }}</h1>
                <div class="car-price">${{ number_format($car->price, 0, '', ',') }}</div>
                <div class="car-description">{{ $car->description }}</div>
            </div>
        </div>
        <div class="car-gallery">
            <h3>Фотографии автомобиля</h3>
            <div style="display:flex; gap:16px; flex-wrap:wrap;">
                @if($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}" alt="Главное фото" width="120">
                @endif
                @foreach($car->images as $img)
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Фото" width="120">
                @endforeach
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="./js/script.js"></script>
    <script src="./js/vehicle-detail.js"></script>
@endpush