@extends('layout.app')

@section('title-block')
    {{ $car->year ?? 'N/A' }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vehicle-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu-overlap-fix.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
@if($car)
<main class="vehicle-detail-page">
    <!-- Top Header Bar -->
    <div class="detail-header">
        
        <div class="header-left">
            <button class="back-btn" onclick="history.back()">
                <span class="material-symbols-outlined">chevron_left</span>
                Back
            </button>
        </div>
        <div class="header-center">
            <span class="stock-number">Stock #: {{ str_pad($car->id, 4, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="header-right">
            <button class="action-btn favorite-btn" onclick="toggleFavorite()">
                <span class="material-symbols-outlined">favorite</span>
            </button>
            <button class="action-btn share-btn" onclick="shareVehicle()">
                <span class="material-symbols-outlined">upload</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="detail-content">
        <!-- Left Section - Car Image -->
        <div class="image-section">
            <div class="dealer-info-bar">
                <span class="dealer-name">D.N B Motors V</span>
                <span class="dealer-phone">(405) 210-6854</span>
            </div>
            
            <div class="car-image-container">
                <div class="image-gallery">
                    @if($car->images && $car->images->count() > 0)
                        <img id="mainCarImage" src="{{ asset('storage/' . $car->images->sortBy('id')->first()->image_path) }}" 
                             alt="{{ $car->year ?? 'N/A' }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}" 
                             class="main-image"
                             onerror="this.src='{{ asset('img/car.jpeg') }}'; console.log('Image failed to load: {{ asset('storage/' . $car->images->sortBy('id')->first()->image_path) }}');">
                    @elseif($car->image)
                        <img id="mainCarImage" src="{{ asset('storage/' . $car->image) }}" 
                             alt="{{ $car->year ?? 'N/A' }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}" 
                             class="main-image"
                             onerror="this.src='{{ asset('img/car.jpeg') }}'; console.log('Image failed to load: {{ asset('storage/' . $car->image) }}');">
                    @else
                        <img id="mainCarImage" src="{{ asset('img/car.jpeg') }}" 
                             alt="{{ $car->year ?? 'N/A' }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}" 
                             class="main-image">
                    @endif
                    
                    <!-- Model name overlay -->
                    <div class="model-overlay">
                        <span class="model-text">{{ $car->carModel->name ?? 'N/A' }}</span>
                    </div>
                    
                    <!-- Navigation arrows -->
                    <button class="gallery-nav prev" onclick="previousImage()" id="prevBtn">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="gallery-nav next" onclick="nextImage()" id="nextBtn">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                    
                    <!-- Image indicators -->
                    <div class="image-indicators" id="imageIndicators">
                        @if($car->images && $car->images->count() > 0)
                            @foreach($car->images as $index => $img)
                                <span class="indicator {{ $index == 0 ? 'active' : '' }}" onclick="goToImage({{ $index }})"></span>
                            @endforeach
                        @elseif($car->image)
                            <span class="indicator active" onclick="goToImage(0)"></span>
                        @endif
                    </div>
                    
                    <!-- Dealer logo overlay -->
                    <div class="dealer-logo">
                        <span>D.N B Motors V</span>
                    </div>
                    
                    <!-- Image counter -->
                    <div class="image-counter" id="imageCounter">
                        @if($car->images && $car->images->count() > 0)
                            1/{{ $car->images->count() }}
                        @elseif($car->image)
                            1/1
                        @else
                            0/0
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Thumbnail Gallery -->
            <div class="thumbnail-gallery">
                @if($car->images && $car->images->count() > 0)
                    @foreach($car->images as $index => $img)
                        <div class="thumbnail {{ $index == 0 ? 'active' : '' }}" onclick="goToImage({{ $index }})">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Gallery Image {{ $index + 1 }}" onerror="this.style.display='none'">
                            <span class="thumbnail-text">{{ $car->carModel->name ?? 'N/A' }}</span>
                        </div>
                    @endforeach
                @elseif($car->image)
                <div class="thumbnail active" onclick="goToImage(0)">
                    <img src="{{ asset('storage/' . $car->image) }}" alt="Main Image" onerror="this.style.display='none'">
                    <span class="thumbnail-text">{{ $car->carModel->name ?? 'N/A' }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Section - Car Details & Pricing -->
        <div class="details-section">
            <div class="vehicle-title">
                <h1>{{ $car->year }} {{ $car->brand->name ?? 'N/A' }}® {{ $car->carModel->name ?? 'N/A' }}</h1>
                <p class="vehicle-subtitle">{{ $car->trim ?? 'SE' }} {{ $car->drivetrain ?? '4WD' }} • {{ number_format($car->mileage ?? 0) }} miles</p>
            </div>

            <!-- Vehicle Specifications -->
            <div class="vehicle-specs">
                <h3 class="specs-title">VEHICLE SPECIFICATIONS</h3>
                <div class="specs-list">
                    <div class="spec-item">
                        <span class="spec-icon">🔢</span>
                        <span class="spec-label">VIN</span>
                        <span class="spec-value">{{ $car->vin ?? 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">📊</span>
                        <span class="spec-label">Mileage</span>
                        <span class="spec-value">{{ $car->mileage ? number_format($car->mileage) : 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">⚙️</span>
                        <span class="spec-label">Engine</span>
                        <span class="spec-value">{{ $car->engine_size ?? 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🚗</span>
                        <span class="spec-label">Drivetrain</span>
                        <span class="spec-value">{{ $car->drivetrain ?? 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🔢</span>
                        <span class="spec-label">Stock No.</span>
                        <span class="spec-value">{{ str_pad($car->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">⚙️</span>
                        <span class="spec-label">Transmission</span>
                        <span class="spec-value">{{ $car->transmission->name ?? 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🚪</span>
                        <span class="spec-label">Trim</span>
                        <span class="spec-value">{{ $car->carModel->name ?? 'N/A' }} {{ $car->bodyType->name ?? '' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🚪</span>
                        <span class="spec-label">Doors</span>
                        <span class="spec-value">{{ $car->doors ?? 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🎨</span>
                        <span class="spec-label">Exterior Color</span>
                        <span class="spec-value">{{ $car->color->name ?? 'N/A' }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-icon">🪑</span>
                        <span class="spec-label">Interior Color</span>
                        <span class="spec-value">{{ $car->interior_color ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="price-section">
                <div class="price-box">
                    <span class="price-label">Our Price</span>
                    <span class="price-amount">${{ number_format($car->price) }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="action-btn schedule-test-drive">
                    <span class="material-symbols-outlined">directions_car</span>
                    SCHEDULE TEST DRIVE
                </button>
            <a href="{{ route('apply_online', ['car_id' => $car->id]) }}" class="action-btn apply-online" style="text-decoration: none; display: inline-block;">
                <span class="material-symbols-outlined">credit_card</span>
                APPLY ONLINE
            </a>
            </div>

            <!-- CARFAX Badge -->
            <div class="carfax-badge">
                <div class="carfax-logo">
                    @if(!empty($car->carfax_url))
                        <a href="{{ (\Illuminate\Support\Str::startsWith($car->carfax_url, ['http://', 'https://']) ? $car->carfax_url : 'https://' . ltrim($car->carfax_url, '/')) }}" target="_blank" rel="noopener noreferrer" class="carfax-link">
                            <span class="carfax-text">CARFAX</span>
                        </a>
                    @else
                        <span class="carfax-text" style="opacity:0.6; cursor: default;">CARFAX</span>
                    @endif
                </div>
            </div>
        </div>
  
    </div>
</div>

      <!-- Full Width Payment Calculator -->
      <div class="full-width-calculator">

        
        <div class="payment-calculator" id="paymentCalculator">
            <div class="calculator-header">
                <h3>Payment Calculator</h3>
            </div>
            
            <div class="calculator-inputs">
                <div class="input-group">
                    <label for="downPayment">Down Payment</label>
                    <input type="number" id="downPayment" value="{{ round($car->price * 0.1) }}" min="0" max="{{ $car->price }}">
                </div>
                
                <div class="input-group">
                    <label for="interestRate">Interest Rate (%)</label>
                    <input type="number" id="interestRate" value="7.29" min="0" max="25" step="0.01">
                </div>
                
                <div class="input-group">
                    <label for="loanTerm">Loan Term (Months)</label>
                    <select id="loanTerm">
                        <option value="36">36 months</option>
                        <option value="48">48 months</option>
                        <option value="60" selected>60 months</option>
                        <option value="72">72 months</option>
                        <option value="84">84 months</option>
                    </select>
                </div>
            </div>
            
            <div class="calculator-results">
                <div class="result-item">
                    <span class="result-label">Monthly Payment</span>
                    <span class="result-value" id="monthlyPayment">${{ number_format($car->monthly_payment) }}</span>
                </div>
            </div>
                    <!-- Vehicle Description inside calculator container -->
        @if($car->description)
        <div class="vehicle-description-inside-calculator">
            <h3>Description</h3>
            <div class="description-content">{!! nl2br(e($car->description)) !!}</div>
        </div>
        @endif
        
            <span>Payment amount is an estimate for illustrative purposes only. 
                This is not an advertisement or offer of credit. Estimated payment excludes taxes, 
                title, registration, license fees, insurance, and additional options. 
                Payment amount may differ based on cash or trade in value due at signing, 
                term, fees, special offers, and applicable tax rate. You must apply for and 
                qualify for credit. Not all customers will qualify. 
                Please contact D.N B Motors V for further information.</span>
        </div>  
    <!-- Full Width Vehicle Equipment -->
    @if($car->equipment && $car->equipment->count() > 0)
    <div class="full-width-equipment">
        <div class="vehicle-equipment">
            <div class="equipment-header" onclick="toggleEquipment()">
                <span class="equipment-title">VEHICLE EQUIPMENT</span>
                <span class="equipment-toggle" id="equipmentToggle">^</span>
            </div>
            <div class="equipment-content" id="equipmentContent">
                <div class="equipment-grid">
                    @php
                        $equipmentByCategory = $car->equipment->groupBy('category');
                        $categories = ['general', 'safety', 'comfort', 'technology'];
                    @endphp
                    
                    @foreach($categories as $category)
                        @if($equipmentByCategory->has($category))
                        <div class="equipment-column">
                            <h4 class="equipment-category-title">{{ ucfirst($category) }}</h4>
                            <ul class="equipment-list">
                                @foreach($equipmentByCategory[$category] as $equipment)
                                    <li>{{ $equipment->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Hidden data for JavaScript -->
    <div id="carData" style="display: none;" 
         data-car-id="{{ $car->id }}"
         data-car-price="{{ $car->price }}"
         data-main-image="{{ $car->images && $car->images->count() > 0 ? asset('storage/' . $car->images->first()->image_path) : ($car->image ? asset('storage/' . $car->image) : '/img/banner.jpg') }}"
         data-images="{{ json_encode($car->images->pluck('image_path')->map(function($path) { return asset('storage/' . $path); })) }}">
    </div>
    
    <!-- Debug information (remove in production) -->
    @if(config('app.debug'))
    <div style="display: none;">
        <p>Debug Info:</p>
        <p>Car Image Path: {{ $car->image }}</p>
        <p>Full Image URL: {{ $car->image ? asset('storage/' . $car->image) : 'No image' }}</p>
        <p>Storage Path: {{ storage_path('app/public/' . $car->image) }}</p>
        <p>Public Path: {{ public_path('storage/' . $car->image) }}</p>
    </div>
    @endif
</main>

@push('scripts')
    <script src="{{ asset("js/vehicle-detail.js") }}"></script>
    <script src="{{ asset("js/car-gallery.js") }}"></script>
    <script>
        function toggleEquipment() {
            const content = document.getElementById('equipmentContent');
            const toggle = document.getElementById('equipmentToggle');
            
            if (content.classList.contains('show')) {
                content.classList.remove('show');
                toggle.classList.remove('rotated');
            } else {
                content.classList.add('show');
                toggle.classList.add('rotated');
            }
        }
    </script>
@endpush

<!-- Test Drive Modal -->
<div id="testDriveModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Schedule Test Drive</h2>
            <button class="modal-close" onclick="closeTestDriveModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="testDriveForm" onsubmit="submitTestDriveForm(event)">
                <div class="form-group">
                    <label for="testDriveName">Full Name *</label>
                    <input type="text" id="testDriveName" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="testDriveEmail">Email *</label>
                    <input type="email" id="testDriveEmail" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="testDrivePhone">Phone *</label>
                    <input type="tel" id="testDrivePhone" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="testDriveDate">Preferred Date *</label>
                    <input type="date" id="testDriveDate" name="preferred_date" required>
                </div>
                
                <div class="form-group">
                    <label for="testDriveTime">Preferred Time *</label>
                    <select id="testDriveTime" name="preferred_time" required>
                        <option value="">Select Time</option>
                        <option value="09:00">9:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="13:00">1:00 PM</option>
                        <option value="14:00">2:00 PM</option>
                        <option value="15:00">3:00 PM</option>
                        <option value="16:00">4:00 PM</option>
                        <option value="17:00">5:00 PM</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="testDriveMessage">Additional Notes</label>
                    <textarea id="testDriveMessage" name="message" rows="3" placeholder="Any special requests or questions..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="agree_terms" required>
                        <span class="checkmark"></span>
                        I agree to the terms and conditions *
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeTestDriveModal()">Cancel</button>
                    <button type="submit" class="btn-primary">Schedule Test Drive</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
