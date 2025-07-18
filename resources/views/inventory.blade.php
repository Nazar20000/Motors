@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/inventory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush


@section('content')
 <main class="inventory-page">
        <div class="container">
            <div class="inventory-layout">
                <!-- Filters Sidebar -->
                <aside class="filters-sidebar">
                    <div class="filter-header">
                        <h2>FILTER</h2>
                        <span class="material-symbols-outlined">tune</span>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Year <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Make / Model <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Mileage <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Price Range <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Drivetrain <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Exterior Color <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Transmission <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Interior Color <span class="material-symbols-outlined">expand_more</span></h3>
                    </div>
                    
                    <button class="reset-filters">Reset Filters</button>
                </aside>

                <!-- Main Content -->
                <div class="inventory-content">
                    <!-- Toolbar -->
                    <div class="inventory-toolbar">
                        <div class="sort-section">
                            <label>
                                <span class="material-symbols-outlined">compare</span>
                                Compare
                            </label>
                            <select class="sort-select">
                                <option>Sort By : Default</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Year: Newest First</option>
                                <option>Mileage: Low to High</option>
                            </select>
                        </div>
                        
                        <div class="results-info">
                            <span>90 Vehicles | Page size: 10 Vehicles</span>
                        </div>
                    </div>

                    <!-- Vehicle Grid -->
                    <div class="inventory-grid">
                        <a href="{{ route('detalis') }}">
                        <!-- Vehicle Card 1 -->
                        <div class="inventory-card">
                            <div class="card-header">
                                <label class="compare-checkbox">
                                    <input type="checkbox"> Compare
                                </label>
                                <div class="card-actions">
                                    <span class="material-symbols-outlined favorite">favorite_border</span>
                                    <button class="apply-online-btn">APPLY ONLINE</button>
                                </div>
                            </div>
                            
                            <div class="vehicle-image">
                                <img src="./img/banner.jpg" alt="2023 Porsche 718 Cayman">
                            </div>
                            
                            <div class="vehicle-details">
                                <h3>2023 PORSCHE 718 CAYMAN</h3>
                                <div class="price-tag">$139,999</div>
                                
                                <div class="specs">
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">confirmation_number</span>
                                        <span>WP0AB2A83PK260411</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">speed</span>
                                        <span>5,678</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span>AUTOMATIC</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span>RWD</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">local_gas_station</span>
                                        <span>GASOLINE</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">door_front</span>
                                        <span>2</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">event_seat</span>
                                        <span>2468</span>
                                    </div>
                                </div>
                                
                                <div class="carfax-section">
                                    <div class="carfax-badge">
                                        <span>SHOW ME THE</span>
                                        <strong>CARFAX</strong>
                                        <span class="carfax-value">GREAT VALUE</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>

                        <!-- Vehicle Card 2 -->
                        <div class="inventory-card">
                            <div class="card-header">
                                <label class="compare-checkbox">
                                    <input type="checkbox"> Compare
                                </label>
                                <div class="card-actions">
                                    <span class="material-symbols-outlined favorite">favorite_border</span>
                                    <button class="apply-online-btn">APPLY ONLINE</button>
                                </div>
                            </div>
                            
                            <div class="vehicle-image">
                                <img src="./img/banner.jpg" alt="2020 Aston Martin Vantage">
                            </div>
                            
                            <div class="vehicle-details">
                                <h3>2020 ASTON MARTIN VANTAGE</h3>
                                <div class="price-tag">$84,999</div>
                                
                                <div class="specs">
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">confirmation_number</span>
                                        <span>SCFSMGAW3LGL03320</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">speed</span>
                                        <span>22,346</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span>AUTOMATIC</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span>RWD</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">local_gas_station</span>
                                        <span>GASOLINE</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">door_front</span>
                                        <span>2</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">event_seat</span>
                                        <span>2390</span>
                                    </div>
                                </div>
                                
                                <div class="carfax-section">
                                    <div class="carfax-badge">
                                        <span>SHOW ME THE</span>
                                        <strong>CARFAX</strong>
                                        <span class="carfax-value good">GOOD VALUE</span>
                                    </div>
                                    <div class="cargurus-badge">
                                        <span class="material-symbols-outlined">check_circle</span>
                                        <span>GOOD DEAL</span>
                                        <span class="cargurus-text">CarGurus</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Card 3 -->
                        <div class="inventory-card">
                            <div class="card-header">
                                <label class="compare-checkbox">
                                    <input type="checkbox"> Compare
                                </label>
                                <div class="card-actions">
                                    <span class="material-symbols-outlined favorite">favorite_border</span>
                                    <button class="apply-online-btn">APPLY ONLINE</button>
                                </div>
                            </div>
                            
                            <div class="vehicle-image">
                                <img src="./img/banner.jpg" alt="2021 Porsche 718 Cayman">
                            </div>
                            
                            <div class="vehicle-details">
                                <h3>2021 PORSCHE 718 CAYMAN</h3>
                                <div class="price-tag">$76,999</div>
                                
                                <div class="specs">
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">confirmation_number</span>
                                        <span>WP0AA2A84MK289902</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">speed</span>
                                        <span>3,015</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span>AUTOMATIC</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">settings</span>
                                        <span>RWD</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">local_gas_station</span>
                                        <span>GASOLINE</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">door_front</span>
                                        <span>2</span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="material-symbols-outlined">event_seat</span>
                                        <span>1002</span>
                                    </div>
                                </div>
                                
                                <div class="carfax-section">
                                    <div class="carfax-badge">
                                        <span>SHOW ME THE</span>
                                        <strong>CARFAX</strong>
                                        <span class="carfax-value">GREAT VALUE</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional vehicle cards would go here -->
                        
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <span>1 of 9</span>
                        <div class="page-numbers">
                            <span class="page-number active">1</span>
                            <span class="page-number">2</span>
                            <span class="page-number">3</span>
                            <span class="page-number">4</span>
                            <span class="page-number">5</span>
                            <span class="page-dots">...</span>
                            <span class="page-number">9</span>
                        </div>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Recently Viewed Section -->
    <section class="recently-viewed">
        <div class="container">
            <h2>RECENTLY VIEWED VEHICLES</h2>
            <div class="recently-viewed-grid">
                <div class="recently-viewed-card">
                    <div class="card-image">
                        <img src="./img/banner.jpg" alt="2023 Porsche 718 Cayman">
                        <div class="card-overlay">
                            <h3>GT4 RS</h3>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4>2023 PORSCHE 718 CA...</h4>
                        <p class="card-price">$139,999</p>
                    </div>
                </div>

                <div class="recently-viewed-card">
                    <div class="card-image">
                        <img src="./img/banner.jpg" alt="2021 Porsche 718 Cayman">
                        <div class="card-overlay">
                            <h3>GT4 RS</h3>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4>2021 PORSCHE 718 CA...</h4>
                        <p class="card-price">$76,999</p>
                    </div>
                </div>

                <div class="recently-viewed-card">
                    <div class="card-image">
                        <img src="./img/banner.jpg" alt="2020 Aston Martin Vantage">
                        <div class="card-overlay">
                            <h3>ASTON MARTIN VANTAGE</h3>
                        </div>
                    </div>
                    <div class="card-info">
                        <h4>2020 ASTON MARTIN V...</h4>
                        <p class="card-price">$84,999</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('scripts')
    <script src="./js/script.js"></script>
    <script src="./js/inventory.js"></script>
@endpush

@endsection