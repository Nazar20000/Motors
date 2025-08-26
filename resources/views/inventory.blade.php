@extends('layout.app')

@section('title-block')
    Inventory - D.N B Motors V
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.1">
    <link rel="stylesheet" href="{{ asset('css/inventory.css') }}?v=1.5">
    <link rel="stylesheet" href="{{ asset('css/inventory-fixed.css') }}?v=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/car-filter.js') }}"></script>
@endpush

@section('content')
<main class="inventory-page">
    <div class="inventory-layout">

        <!-- Left Sidebar - Filters -->
        <aside class="filter-sidebar">
            <div class="filter-mode">
                <button class="filter-tab active">
                    <span class="material-symbols-outlined">filter_list</span>
                    Standard
                </button>
                <button class="filter-tab">
                    <span class="material-symbols-outlined">bolt</span>
                    AI Mode
                </button>
            </div>
            
            <div class="filter-sections">
                <div class="filter-section active">
                    <div class="filter-header">
                        <span>Price</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                    <div class="filter-content">
                        <div class="price-range">
                            <input type="number" placeholder="Min" class="filter-input" value="{{ $filters['price_min'] ?? '' }}">
                            <input type="number" placeholder="Max" class="filter-input" value="{{ $filters['price_max'] ?? '' }}">
                        </div>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-header">
                        <span>Year</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                    <div class="filter-content">
                        <div class="year-range">
                            <input type="number" placeholder="From" class="filter-input" value="{{ $filters['year_from'] ?? '' }}">
                            <input type="number" placeholder="To" class="filter-input" value="{{ $filters['year_to'] ?? '' }}">
                        </div>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-header">
                        <span>Make</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                    <div class="filter-content">
                        <select class="filter-select" name="brand_id">
                            <option value="">All Makes</option>
                            @foreach($brands ?? [] as $brand)
                                <option value="{{ $brand->id }}" {{ ($filters['brand_id'] ?? '') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-header">
                        <span>Model</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                    <div class="filter-content">
                        <select class="filter-select" name="model_id">
                            <option value="">All Models</option>
                        </select>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-header">
                        <span>Body Type</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                    <div class="filter-content">
                        <select class="filter-select" name="body_type_id">
                            <option value="">All Body Types</option>
                            @foreach($bodyTypes ?? [] as $bodyType)
                                <option value="{{ $bodyType->id }}" {{ ($filters['body_type_id'] ?? '') == $bodyType->id ? 'selected' : '' }}>
                                    {{ $bodyType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-header">
                        <span>Body Subtype</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-header">
                        <span>Drivetrain</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </div>
                </div>
            </div>
            
            <div class="filter-footer">
                <button class="see-all-filters">
                    See all filters
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>
        </aside>


        <div class="inventory-content">
            <div class="inventory-grid">
                @if($cars->count() > 0)
                @foreach($cars as $car)
                <div class="vehicle-card" onclick="handleCardClick(event, {{ $car->id }})" style="cursor: pointer;">
                    <!-- Header with Apply Online and Icons -->
                    <div class="card-header">
                        <div class="header-left">
                        <a href="{{ route('apply_online', ['car_id' => $car->id]) }}"><span class="apply-online-text">APPLY ONLINE</span> </a>
                        </div>
                        <div class="header-right">
                            <button class="icon-btn camera-btn" onclick="event.stopPropagation(); event.preventDefault(); return false;">
                                <span class="material-symbols-outlined">camera_alt</span>
                            </button>
                            <button class="icon-btn heart-btn" onclick="event.stopPropagation(); event.preventDefault(); return false;">
                                <span class="material-symbols-outlined">favorite</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Main Car Image -->
                    <div class="vehicle-image-container">
                        @if($car->images && $car->images->count() > 0)
                            <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" 
                                 alt="{{ $car->brand->name ?? 'Car' }} {{ $car->carModel->name ?? '' }}" 
                                 class="vehicle-image"
                                 onerror="this.src='{{ asset('img/car.jpeg') }}'">
                        @elseif($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" 
                                 alt="{{ $car->brand->name ?? 'Car' }} {{ $car->carModel->name ?? '' }}" 
                                 class="vehicle-image"
                                 onerror="this.src='{{ asset('img/car.jpeg') }}'">
                        @else
                            <img src="{{ asset('img/car.jpeg') }}" 
                                 alt="{{ $car->brand->name ?? 'Car' }} {{ $car->carModel->name ?? '' }}" 
                                 class="vehicle-image fallback-image">
                        @endif
                        
                        <!-- Car Model Overlay -->
                        <div class="car-model-overlay">
                            <span class="model-text">{{ $car->carModel->name ?? 'N/A' }}</span>
                        </div>
                        
                        <!-- Year and Engine Overlay -->
                        <div class="year-engine-overlay">
                            <span class="year-text">{{ $car->year }}</span>

                        </div>
                    </div>
                    
                                         <!-- Car Title and Price -->
                     <div class="car-title-price">
                         <div class="car-title">
                             <span class="make-model"> {{ $car->year }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? '' }}</span>
                         </div>
                         <div class="car-price">
                             <span class="price-text">${{ number_format($car->price) }}</span>
                         </div>
                     </div>
                    
                    <!-- Car Specifications -->
                      <div class="car-specifications">
                                                     <div class="specs-single-column">
                              <div class="spec-item">
                                  <span class="spec-icon">⛽</span>
                                  <span class="spec-label">Fuel Type:</span>
                                  <span class="spec-value">{{ $car->fuel_type ?? 'N/A' }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">📋</span>
                                  <span class="spec-label">Stock No.:</span>
                                  <span class="spec-value">{{ str_pad($car->id, 4, '0', STR_PAD_LEFT) }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">📊</span>
                                  <span class="spec-label">Mileage:</span>
                                  <span class="spec-value">{{ $car->mileage ? number_format($car->mileage) : 'N/A' }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">🚗</span>
                                  <span class="spec-label">Drive Type:</span>
                                  <span class="spec-value">{{ $car->bodyType->name ?? 'N/A' }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">🎨</span>
                                  <span class="spec-label">Color:</span>
                                  <span class="spec-value">{{ $car->color->name ?? 'N/A' }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">🔢</span>
                                  <span class="spec-label">VIN:</span>
                                  <span class="spec-value">{{ $car->vin ?? 'N/A' }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">⚙️</span>
                                  <span class="spec-label">Transmission:</span>
                                  <span class="spec-value">{{ $car->transmission->name ?? 'N/A' }}</span>
                              </div>
                              <div class="spec-item">
                                  <span class="spec-icon">🚪</span>
                                  <span class="spec-label">Doors:</span>
                                  <span class="spec-value">{{ $car->doors ?? 'N/A' }}</span>
                              </div>
                           </div>
                      </div>

                    <!-- CARFAX Information -->
                     <div class="carfax-section">
                         @if($car->carfax_url)
                             <a href="{{ (\Illuminate\Support\Str::startsWith($car->carfax_url, ['http://', 'https://']) ? $car->carfax_url : 'https://' . ltrim($car->carfax_url, '/')) }}" target="_blank" rel="noopener noreferrer" class="carfax-link" onclick="event.stopPropagation();">
                                 <div class="carfax-logo">
                                     <span class="carfax-text">CARFAX</span>
                                 </div>
                             </a>
                         @else
                             <div class="carfax-placeholder">
                                 <div class="carfax-logo disabled">
                                     <span class="carfax-text">CARFAX</span>
                                 </div>
                                 <small style="color: #888; font-size: 10px;">Report not available</small>
                             </div>
                         @endif
                         <div class="monthly-payment-component">
                             <div class="payment-info">
                                 <span class="monthlyPayment">${{ number_format($car->monthly_payment) }}/mo</span>
                                 <div class="info-icon" onmouseenter="showPaymentTooltip(event, {{ $car->id }}, {{ $car->price }})" onmouseleave="hidePaymentTooltip()" onclick="event.stopPropagation(); event.preventDefault(); return false;">
                                     <span class="material-symbols-outlined">help</span>
                                 </div>
                             </div>
                             <div class="payment-button">
                                 <span class="material-symbols-outlined">attach_money</span>
                             </div>
                         </div>
                     </div>
                </div>
                @endforeach
                @else
                <div class="no-cars-found">
                    <div class="no-cars-content">
                        <span class="material-symbols-outlined">directions_car</span>
                        <h3>No cars found</h3>
                        <p>Try adjusting your filters or browse our complete inventory.</p>
                        <button class="clear-filters-btn" onclick="clearAllFilters()">
                            <span class="material-symbols-outlined">refresh</span>
                            Clear All Filters
                        </button>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Modern Pagination -->
            @if($cars->count() > 0)
            <div class="pagination">
                <div class="pagination-info">
                    <span>Showing {{ $cars->firstItem() ?? 0 }} to {{ $cars->lastItem() ?? 0 }} of {{ $cars->total() }} results</span>
                </div>
                
                <div class="pagination-controls">
                    @if($cars->hasPages())
                        <!-- Previous Button -->
                        @if($cars->onFirstPage())
                            <button class="pagination-arrow" disabled>
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                        @else
                            <a href="{{ $cars->previousPageUrl() }}" class="pagination-arrow">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        @endif
                        
                        <!-- Page Numbers -->
                        <div class="pagination-numbers">
                            @php
                                $start = max(1, $cars->currentPage() - 2);
                                $end = min($cars->lastPage(), $cars->currentPage() + 2);
                            @endphp
                            
                            @if($start > 1)
                                <a href="{{ $cars->url(1) }}" class="pagination-number">1</a>
                                @if($start > 2)
                                    <span class="pagination-dots">...</span>
                                @endif
                            @endif
                            
                            @for($i = $start; $i <= $end; $i++)
                                @if($i == $cars->currentPage())
                                    <span class="pagination-number active">{{ $i }}</span>
                                @else
                                    <a href="{{ $cars->url($i) }}" class="pagination-number">{{ $i }}</a>
                                @endif
                            @endfor
                            
                            @if($end < $cars->lastPage())
                                @if($end < $cars->lastPage() - 1)
                                    <span class="pagination-dots">...</span>
                                @endif
                                <a href="{{ $cars->url($cars->lastPage()) }}" class="pagination-number">{{ $cars->lastPage() }}</a>
                            @endif
                        </div>
                        
                        <!-- Next Button -->
                        @if($cars->hasMorePages())
                            <a href="{{ $cars->nextPageUrl() }}" class="pagination-arrow">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        @else
                            <button class="pagination-arrow" disabled>
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

@push('scripts')

    <script src="{{ asset('js/inventory.js') }}"></script>
@endpush

<!-- Payment Info Tooltip -->
<div id="paymentTooltip" class="payment-tooltip">
    <div class="tooltip-content">
        <div class="tooltip-header">
            <h3>Monthly Payment of</h3>
        </div>
        <div class="tooltip-body">
            <div class="payment-amount-large" id="tooltipPaymentAmount">$0</div>
            <div class="payment-details" id="tooltipPaymentDetails">
                Payment calculated based on a 60 month loan with 7.29% interest and $0 down.
            </div>
        </div>
        <div class="tooltip-footer">
            <button class="get-qualified-btn" onclick="getPreQualified(); event.stopPropagation(); event.preventDefault(); return false;">
                Get Pre-Qualified
            </button>
        </div>
    </div>
</div>

@endsection
