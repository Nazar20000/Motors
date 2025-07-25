@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/vehicle-detail.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<main class="car-details-page">
    <div class="container">
        <div class="car-details-layout">
            <div class="car-main-photo">
                <img id="mainCarImage" src="{{ $car->image ? asset('storage/' . $car->image) : '' }}" alt="Главное фото">
            </div>
            <div class="car-info">
                <h1>{{ $car->year }} {{ $car->brand }} {{ $car->model }}</h1>
                <div class="car-price">${{ number_format($car->price, 0, '', ',') }}</div>
                <div class="car-description">{{ $car->description }}</div>
            </div>
        </div>
        <div class="car-gallery">
            <h3>Фотографии автомобиля</h3>
            <div id="car-thumbs" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                @if($car->image)
                    <img class="car-thumb active-thumb" src="{{ asset('storage/' . $car->image) }}" alt="Главное фото" data-full="{{ asset('storage/' . $car->image) }}">
                @endif
                @foreach($car->images as $img)
                    <img class="car-thumb" src="{{ asset('storage/' . $img->image_path) }}" alt="Фото" data-full="{{ asset('storage/' . $img->image_path) }}">
                @endforeach
            </div>
        </div>
    </div>
</main>
@push('scripts')
<script>
    const mainImg = document.getElementById('mainCarImage');
    const thumbs = document.querySelectorAll('.car-thumb');
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            mainImg.src = this.dataset.full;
            thumbs.forEach(t => t.classList.remove('active-thumb'));
            this.classList.add('active-thumb');
        });
    });
</script>
@endpush
@endsection