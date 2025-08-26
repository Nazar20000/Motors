@extends('layout.app')

@section('title-block')
    About Us
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')

    <!-- About Us Page -->
    <main class="about-us-page">
        <div class="page-banner">
            <h1>ABOUT US</h1>
        </div>
        
        <div class="container">
            <section class="about-content">
                <div class="about-text">
                    <div class="welcome-header">
                        <h2>WELCOME TO</h2>
                        <h1>D.N B Motors V</h1>
                    </div>
                    
                    <div class="about-description">
                        <p>With years of experience in the automotive industry, we take pride in providing high-quality, reliable vehicles at competitive prices. Our dealership is built on trust, transparency, and a true passion for helping customers find the right car to fit their needs and budget.</p>
                        
                        <p>From the moment you step onto our lot or visit us online, our goal is to make your car-buying experience smooth, honest, and hassle-free. Whether you're looking to finance, trade-in, or purchase with cash, our knowledgeable team is here to guide you through every step of the process.</p>
                        
                        <p>We’re not just here to sell cars — we’re here to build long-lasting relationships. That’s why so many of our customers come back for their next purchase and refer friends and family. We work hard to earn your trust and exceed your expectations.
</p>
                        
                        <p>Explore our current inventory online or visit us in person to see what we have available. If you find something you like, give us a call or schedule a test drive — we’ll take care of the rest.
                            We look forward to helping you drive away in a vehicle you love</p>
                    </div>
                </div>
                
                <div class="about-image">
                    <img src="./img/banner.jpg" alt="BucketBuddy Auto LLC Showroom" />
                    <div class="image-overlay">
                        <div class="overlay-content">
                            <h3>Visit Our Showroom</h3>
                            <p>Experience our wide selection of quality vehicles</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

@push('scripts')

    <script src="{{ asset('js/about-us.js') }}"></script>
@endpush

@endsection
