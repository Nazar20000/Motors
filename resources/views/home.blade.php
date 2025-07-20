@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="/css/style.css">
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
                <select class="search-select">
                    <option>Any Year</option>
                        <option>2030</option>
                        <option>2029</option>
                        <option>2028</option>
                        <option>2027</option>
                        <option>2026</option>
                        <option>2025</option>
                        <option>2024</option>
                        <option>2023</option>
                        <option>2022</option>
                        <option>2021</option>
                        <option>2020</option>
                        <option>2019</option>
                        <option>2018</option>
                        <option>2017</option>
                        <option>2016</option>
                        <option>2015</option>
                        <option>2014</option>
                        <option>2013</option>
                        <option>2012</option>
                        <option>2011</option>
                        <option>2010</option>
                        <option>2009</option>
                        <option>2008</option>
                        <option>2007</option>
                        <option>2006</option>
                        <option>2005</option>
                        <option>2004</option>
                        <option>2003</option>
                        <option>2002</option>
                        <option>2001</option>
                        <option>2000</option>
                        <option>1999</option>
                </select>
                <select class="search-select">
                    <option>Any Make</option>
                    <option>Tesla</option>
                    <option>BMW</option>
                    <option>Mercedes</option>
                    <option>Audi</option>
                    <option>Porsche</option>
                    <option>Acura</option>
                    <option>Alfa Romeo</option>
                    <option>Aston Martin</option>
                    <option>Bentley</option>
                    <option>Bugatti</option>
                    <option>Buick</option>
                    <option>Cadillac</option>
                    <option>Chevrolet (Chevy)</option>
                    <option>Chrysler</option>
                    <option>Dodge</option>
                    <option>Ferrari</option>
                    <option>Fiat</option>
                    <option>Ford</option>
                    <option>Genesis</option>
                    <option>GMC</option>
                    <option>Honda</option>
                    <option>Hummer</option>
                    <option>Hyundai</option>
                    <option>Infiniti</option>
                    <option>Jaguar</option>
                    <option>Jeep</option>
                    <option>Kia</option>
                    <option>Koenigsegg</option>
                    <option>Land Rover</option>
                    <option>Lexus</option>
                    <option>Lincoln</option>
                    <option>Lotus</option>
                    <option>Lucra</option>
                    <option>Lucid Motors</option>
                    <option>Maserati</option>
                    <option>Mazda</option>
                    <option>McLaren</option>
                    <option>Mercedes-Benz</option>
                    <option>Mini</option>
                    <option>Mitsubishi</option>
                    <option>Nissan</option>
                    <option>Pagani</option>
                    <option>Polestar</option>
                    <option>Ram</option>
                    <option>Rivian</option>
                    <option>Rolls-Royce</option>
                    <option>Subaru</option>
                    <option>Toyota</option>
                    <option>Volkswagen</option>
                    <option>Volvo</option>
                </select>
                <select class="search-select">
                    <option>Any Model</option>
                    <option>Model 3</option>
                    <option>Model Y</option>
                    <option>Model S</option>
                </select>
                <select class="search-select">
                    <option>Any Body Type</option>
                    <option>Sedan</option>
                    <option>SUV</option>
                    <option>Coupe</option>
                    <option>Hatchback</option>
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

    <section class="featured-vehicles">
        <div class="container">
            <h2>FEATURED VEHICLES</h2>
            <div class="vehicles-grid">
                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./resurs/car1.jpeg" alt="2013 Ford C-Max">
                        <div class="vehicle-badges">
                            <span class="badge plug-in">PLUG IN</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <h3>2013 FORD C-MAX ENERGI</h3>
                        <p class="price">$7,999</p>
                        <div class="vehicle-details">
                            <span><span class="material-symbols-outlined">settings</span> AUTOMATIC</span>
                            <span><span class="material-symbols-outlined">local_gas_station</span> GASOLINE</span>
                            <span><span class="material-symbols-outlined">speed</span> 45,123</span>
                        </div>
                        <button class="apply-btn">APPLY ONLINE</button>
                    </div>
                </div>

                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./resurs/car2.jpeg" alt="2016 Tesla Model X">
                        <div class="vehicle-badges">
                            <span class="badge electric">ELECTRIC</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <h3>2016 TESLA MODEL X</h3>
                        <p class="price">$19,999</p>
                        <div class="vehicle-details">
                            <span><span class="material-symbols-outlined">settings</span> AUTOMATIC</span>
                            <span><span class="material-symbols-outlined">electric_bolt</span> ELECTRIC</span>
                            <span><span class="material-symbols-outlined">speed</span> 89,456</span>
                        </div>
                        <button class="apply-btn">APPLY ONLINE</button>
                    </div>
                </div>

                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./resurs/car3.jpeg" alt="2018 Lexus LC">
                        <div class="vehicle-badges">
                            <span class="badge lexus">LEXUS LC500</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <h3>2018 LEXUS LC</h3>
                        <p class="price">$64,999</p>
                        <div class="vehicle-details">
                            <span><span class="material-symbols-outlined">settings</span> AUTOMATIC</span>
                            <span><span class="material-symbols-outlined">local_gas_station</span> GASOLINE</span>
                            <span><span class="material-symbols-outlined">speed</span> 23,789</span>
                        </div>
                        <button class="apply-btn">APPLY ONLINE</button>
                    </div>
                </div>

                                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./resurs/car3.jpeg" alt="2018 Lexus LC">
                        <div class="vehicle-badges">
                            <span class="badge lexus">LEXUS LC500</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <h3>2018 LEXUS LC</h3>
                        <p class="price">$64,999</p>
                        <div class="vehicle-details">
                            <span><span class="material-symbols-outlined">settings</span> AUTOMATIC</span>
                            <span><span class="material-symbols-outlined">local_gas_station</span> GASOLINE</span>
                            <span><span class="material-symbols-outlined">speed</span> 23,789</span>
                        </div>
                        <button class="apply-btn">APPLY ONLINE</button>
                    </div>
                </div>

                                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./resurs/car3.jpeg" alt="2018 Lexus LC">
                        <div class="vehicle-badges">
                            <span class="badge lexus">LEXUS LC500</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <h3>2018 LEXUS LC</h3>
                        <p class="price">$64,999</p>
                        <div class="vehicle-details">
                            <span><span class="material-symbols-outlined">settings</span> AUTOMATIC</span>
                            <span><span class="material-symbols-outlined">local_gas_station</span> GASOLINE</span>
                            <span><span class="material-symbols-outlined">speed</span> 23,789</span>
                        </div>
                        <button class="apply-btn">APPLY ONLINE</button>
                    </div>
                </div>

                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./resurs/car4.jpeg" alt="2023 Kia EV6">
                        <div class="vehicle-badges">
                            <span class="badge ev">EV6 WIND</span>
                        </div>
                    </div>
                    <div class="vehicle-info">
                        <h3>2023 KIA EV6</h3>
                        <p class="price">$17,999</p>
                        <div class="vehicle-details">
                            <span><span class="material-symbols-outlined">settings</span> AUTOMATIC</span>
                            <span><span class="material-symbols-outlined">electric_bolt</span> ELECTRIC</span>
                            <span><span class="material-symbols-outlined">speed</span> 12,345</span>
                        </div>
                        <button class="apply-btn">APPLY ONLINE</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-makes">
        <div class="container">
            <h2>POPULAR MAKES</h2>
            <div class="makes-slider-container">
                <button class="slider-btn prev" id="prevBtn">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <div class="makes-slider-wrapper">  
                    <div class="makes-slider" id="makesSlider">
                        <div class="make-item">
                            <img src="./resurs/honda.jpeg" alt="Honda">
                            <span>HONDA</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/HYUNDAY.jpeg" alt="Hyundai">
                            <span>HYUNDAI</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/KIA.jpeg" alt="Kia">
                            <span>KIA</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/LAND.jpeg" alt="Land Rover">
                            <span>LAND ROVER</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/BMW.jpeg" alt="BMW">
                            <span>BMW</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/MERCEDES.jpeg" alt="Mercedes">
                            <span>MERCEDES</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/AUDI.jpeg" alt="Audi">
                            <span>AUDI</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/TESLA.png" alt="Tesla">
                            <span>TESLA</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/KTA.png" alt="Audi">
                            <span>KTA</span>
                        </div>
                        <div class="make-item">
                            <img src="./resurs/PORSHE.jpeg" alt="PORSHE">
                            <span>PORSHE</span>
                        </div>
                    </div>
                </div>
                <button class="slider-btn next" id="nextBtn">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </section>

    <section class="welcome">
        <div class="container">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h3>WELCOME TO</h3>
                    <h2>BD.N B MOTORS V</h2>
                    <p>At D.N B Motors V, we’re committed to providing the ultimate automobile 
                        buying experience. As your #1 source for high-quality pre-owned vehicles, 
                        we take pride in offering exceptional value and a smooth, 
                        stress-free process from start to finish.
                        Thanks to our strong relationships within the dealer community, 
                        we’re able to source a wide selection of lease returns and trade-ins 
                        at outstanding prices — and we pass those savings directly on to you.
                        We also provide a full range of financing options tailored to your needs, 
                        whether you're buying your first car or upgrading to your next one.
                        If you need help with any part of the buying process, please don’t hesitate 
                        to contact us. We’re here to help you every step of the way.</p>
                </div>
                <div class="welcome-image">
                    <img src="./resurs/car2.jpeg" alt="Bucket Buddy Auto Building">
                </div>
            </div>
        </div>
    </section>
    
@push('scripts')
    <script src="/js/script.js"></script>
@endpush
    
@endsection