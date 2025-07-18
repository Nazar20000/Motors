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

    <main class="vehicle-detail-page">
        <div class="container">
            <div class="vehicle-detail-layout">
                <!-- Vehicle Images -->
                <div class="vehicle-images">
                    <div class="main-image">
                        <img src="./img/banner.jpg" alt="Tesla Model 3" id="mainImage">
                        <div class="image-controls">
                            <button class="image-control prev">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button class="image-control next">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </div>
                        <div class="image-counter">
                            <span class="material-symbols-outlined">photo_library</span>
                            <span>23</span>
                        </div>
                    </div>

                    <div class="thumbnail-gallery">
                        <div class="thumbnail active">
                            <img src="./img/banner.jpg" alt="Tesla Model 3">
                        </div>
                        <div class="thumbnail">
                            <img src="./img/banner.jpg" alt="Tesla Model 3">
                        </div>
                        <div class="thumbnail">
                            <img src="./img/banner.jpg" alt="Tesla Model 3">
                        </div>
                        <div class="thumbnail">
                            <img src="./img/banner.jpg" alt="Tesla Model 3">
                        </div>
                        <div class="thumbnail">
                            <img src="./img/banner.jpg" alt="Tesla Model 3">
                        </div>
                        <button class="thumbnail-nav">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>

                <!-- Vehicle Specifications -->
                <div class="vehicle-specs">
                    <div class="specs-header">
                        <h1>VEHICLE SPECIFICATIONS</h1>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">confirmation_number</span>
                        <span class="spec-label">VIN :</span>
                        <span class="spec-value">5YJ3E1EA4NF144729</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">speed</span>
                        <span class="spec-label">Mileage :</span>
                        <span class="spec-value">77,587</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">electric_bolt</span>
                        <span class="spec-label">Engine :</span>
                        <span class="spec-value">AC ELECTRIC MOTOR</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">electric_bolt</span>
                        <span class="spec-label">Drivetrain :</span>
                        <span class="spec-value">RWD</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">inventory</span>
                        <span class="spec-label">Stock No. :</span>
                        <span class="spec-value">1081</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">settings</span>
                        <span class="spec-label">Transmission :</span>
                        <span class="spec-value">AUTOMATIC</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">directions_car</span>
                        <span class="spec-label">Trim :</span>
                        <span class="spec-value">STANDARD SEDAN 4D</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">door_front</span>
                        <span class="spec-label">Doors :</span>
                        <span class="spec-value">4</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">palette</span>
                        <span class="spec-label">Exterior Color :</span>
                        <span class="spec-value">-</span>
                    </div>

                    <div class="spec-item">
                        <span class="material-symbols-outlined">chair</span>
                        <span class="spec-label">Interior Color :</span>
                        <span class="spec-value">-</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="action-btn primary">SCHEDULE TEST DRIVE</button>
                        <button class="action-btn primary">APPLY ONLINE</button>
                        <button class="action-btn secondary">REQUEST A QUOTE</button>
                    </div>

                    <!-- CarFax Section -->
                    <div class="carfax-section">
                        <div class="carfax-badge">
                            <span>SHOW ME THE</span>
                            <strong>CARFAX</strong>
                            <span class="carfax-value">GREAT VALUE</span>
                        </div>

                        <div class="cargurus-badge">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>GOOD DEAL</span>
                            <div class="cargurus-text">CarGurus</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@push('scripts')
    <script src="./js/script.js"></script>
    <script src="./js/vehicle-detail.js"></script>
@endpush

@endsection