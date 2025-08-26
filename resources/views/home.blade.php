@extends('layout.app')

@section('title-block')
    Home
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>DRIVING<br>REDEFINED</h1>
                <p>Our impressive line-up of cars will make your car decision process much faster and easier</p>
            </div>
            <div class="search-form">
                <select class="search-select" name="year">
                    <option value="">Any Year</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                <select class="search-select" name="brand_id">
                    <option value="">Any Make</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <select class="search-select" name="model_id">
                    <option value="">Any Model</option>
                    @foreach($carModels as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
                <select class="search-select" name="body_type_id">
                    <option value="">Any Body Type</option>
                    @foreach($bodyTypes as $bodyType)
                        <option value="{{ $bodyType->id }}">{{ $bodyType->name }}</option>
                    @endforeach
                </select>
                <button class="search-btn">SEARCH</button>
            </div>
        </div>
    </section>

    <section class="how-easy">
        <div class="container">
            <h2>HOW EASY IS BUYING A CAR FROM US?</h2>
            <div class="steps">
                <div class="step">
                    <span class="material-symbols-outlined step-icon">home</span>
                    <h3>Search Our Inventory</h3>
                    <p>Let us know exactly what you're in the market for and we'll help you find it. With access to auctions and exclusive industry sources, we can help you get into the ride you want.</p>
                </div>
                <div class="step">
                    <span class="material-symbols-outlined step-icon">person</span>
                    <h3>Schedule Test Drive</h3>
                    <p>The best way to help make your final decision is to test drive your dream car. It lets you experience the thrill of the vehicle for yourself. Our friendly, experienced staff are here to help!</p>
                </div>
                <div class="step">
                    <span class="material-symbols-outlined step-icon">check_circle</span>
                    <h3>Get Approved Today</h3>
                    <p>With relations with multiple lenders, we are bound to get you financed! Good Credit, Bad Credit, First Time Buyer? Our lenders work with all types of scores and situations.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-makes">
        <div class="container">
            <h2>POPULAR MAKES</h2>
            <div class="makes-slider">
                <button class="slider-arrow slider-arrow-left" onclick="slideMakes('left')">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <div class="makes-container">
                    @php
                        $paths = glob(public_path('resurs/*.{png,jpg,jpeg,svg}'), GLOB_BRACE);
                        $seen = [];
                        $logos = [];
                        $nameMap = [
                            'mercedes' => 'Mercedes-Benz',
                            'hyunday' => 'Hyundai',
                            'porshe' => 'Porsche',
                            'land' => 'Land Rover',
                            'gmc' => 'GMC',
                            'bmw' => 'BMW',
                            'ram' => 'RAM',
                        ];
                        foreach ($paths as $absPath) {
                            $file = basename($absPath);
                            $nameKey = strtolower(pathinfo($file, PATHINFO_FILENAME));
                            if (isset($seen[$nameKey])) continue;
                            $seen[$nameKey] = true;
                            $display = isset($nameMap[$nameKey]) ? $nameMap[$nameKey] : ucwords(strtolower($nameKey));
                            $logos[] = [
                                'src' => asset('resurs/' . $file),
                                'name' => $display,
                            ];
                        }
                    @endphp
                    @foreach($logos as $logo)
                        <div class="make-item">
                            <img src="{{ $logo['src'] }}" alt="{{ $logo['name'] }}">
                            <span class="make-name">{{ $logo['name'] }}</span>
                        </div>
                    @endforeach
                </div>
                <button class="slider-arrow slider-arrow-right" onclick="slideMakes('right')">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>

        </div>
    </section>

    <section class="featured-vehicles">
        <div class="container">
            <h2>FEATURED VEHICLES</h2>
            @if($featuredCars->count() > 0)
                <div class="vehicles-slider">
                    <button class="slider-arrow slider-arrow-left" onclick="slideVehicles('left')">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <div class="vehicles-container">
                        @foreach($featuredCars as $car)
                            <div class="vehicle-card">
                                <div class="vehicle-image">
                                    @if($car->images->count() > 0)
                                        <img src="{{ asset('storage/' . $car->images->sortBy('id')->first()->image_path) }}" alt="{{ $car->full_name }}">
                                    @else
                                        <img src="{{ asset('img/car.jpeg') }}" alt="{{ $car->full_name }}" class="fallback-image">
                                    @endif
                                    <div class="vehicle-badges">
                                        @if($car->fuel_type)
                                            <span class="badge {{ strtolower($car->fuel_type) }}">{{ strtoupper($car->fuel_type) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="vehicle-info">
                                    <h3>{{ strtoupper($car->full_name) }}</h3>
                                    <p class="price">{{ $car->formatted_price }}</p>
                                    <div class="vehicle-details">
                                        <span><span class="material-symbols-outlined">settings</span> {{ $car->transmission ? strtoupper($car->transmission->name) : 'N/A' }}</span>
                                        <span><span class="material-symbols-outlined">local_gas_station</span> {{ $car->fuel_type ? strtoupper($car->fuel_type) : 'N/A' }}</span>
                                        <span><span class="material-symbols-outlined">speed</span> {{ $car->formatted_mileage }}</span>
                                    </div>
                                    <button class="apply-btn" onclick="window.location.href='{{ route('detalis', $car->id) }}'">VIEW DETAILS</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="slider-arrow slider-arrow-right" onclick="slideVehicles('right')">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            @else
                <div class="empty-featured">
                    <div class="empty-content">
                        <span class="material-symbols-outlined empty-icon">directions_car</span>
                        <h3>Currently Empty</h3>
                        <p>No featured vehicles available at the moment. Check back soon for new arrivals!</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>READY TO FIND YOUR DREAM CAR?</h2>
                <p>Browse our extensive inventory and find the perfect vehicle for your needs</p>
                <button class="cta-btn" onclick="window.location.href='{{ route('inventory') }}'">
                    VIEW ALL VEHICLES
                </button>
            </div>
        </div>
    </section>

    <section class="welcome">
        <div class="container">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h3>WELCOME TO</h3>
                    <h2>D.N B MOTORS V</h2>
                    <p>At D.N B Motors V, we're committed to providing the ultimate automobile 
                        buying experience. As your #1 source for high-quality pre-owned vehicles, 
                        we take pride in offering exceptional value and a smooth, 
                        stress-free process from start to finish.
                        Thanks to our strong relationships within the dealer community, 
                        we're able to source a wide selection of lease returns and trade-ins 
                        at outstanding prices — and we pass those savings directly on to you.
                        We also provide a full range of financing options tailored to your needs, 
                        whether you're buying your first car or upgrading to your next one.
                        If you need help with any part of the buying process, please don't hesitate 
                        to contact us. We're here to help you every step of the way.</p>
                </div>
                <div class="welcome-image">
                    <img src="./img/banner.jpg" alt="Bucket Buddy Auto Building">
                </div>
            </div>
        </div>
    </section>
    
@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/car-filter.js') }}"></script>
@endpush
    
@endsection
