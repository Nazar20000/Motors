@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/about-us.css">
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
                        <h1>BUCKETBUDDY AUTO LLC</h1>
                    </div>
                    
                    <div class="about-description">
                        <p>With years of experience serving the area, our dealership is dedicated to offering high-quality, pre-owned vehicles to our customers. From the moment you walk through our door, we're committed to providing you with a great car-buying experience. With our skilled sales staff and financing options, we'll help you get the vehicle you want, at the great price you deserve.</p>
                        
                        <p>Our goal is for you to be so delighted with your vehicle purchase that you'll come see us when you need your next car and will happily recommend us to friends and family. Customer referrals are the ultimate compliment! With many vehicle shopping options available, we differentiate ourselves by understanding our local car-buying community and satisfying its needs by helping valued local customers like you, find the vehicle that's the "right fit".</p>
                        
                        <p>Feel free to browse our inventory online and check out the Featured Vehicles section on our homepage. If you see a vehicle you like, submit an online quote request, or contact us to schedule a test drive.</p>
                        
                        <p>To learn more about our dealership and how we can help with your next vehicle purchase, please call or stop by in person. We look forward to meeting you.</p>
                    </div>
                </div>
                
                <div class="about-image">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%20%D0%BE%D1%82%202025-07-19%2001-38-11-BGONVS8dPdxNU7clmb81V728wKPt4A.png" alt="BucketBuddy Auto LLC Showroom" />
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
    <script src="./js/script.js"></script>
    <script src="./js/about-us.js"></script>
@endpush

@endsection