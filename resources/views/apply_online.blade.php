@extends('layout.app')

@section('title-block')
    Apply Online
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/apply-online.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
@endpush


@section('content')

    <!-- Apply Online Page -->
    <main class="apply-online-page">
        <div class="page-banner">
            <h1>APPLY ONLINE</h1>
        </div>
        
        @if($car)
        <!-- Vehicle Information Display -->
        <div class="container">
            <div class="vehicle-info-section">
                <h2>Vehicle Information</h2>
                <div class="vehicle-info-grid">
                    <div class="vehicle-image">
                        @if($car->images && $car->images->count() > 0)
                            <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" 
                                 alt="{{ $car->year }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}" 
                                 onerror="this.src='{{ asset('img/car.jpeg') }}'">
                        @elseif($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" 
                                 alt="{{ $car->year }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}" 
                                 onerror="this.src='{{ asset('img/car.jpeg') }}'">
                        @else
                            <img src="{{ asset('img/car.jpeg') }}" 
                                 alt="{{ $car->year }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}">
                        @endif
                    </div>
                    <div class="vehicle-details">
                        <h3>{{ $car->year }} {{ $car->brand->name ?? 'N/A' }} {{ $car->carModel->name ?? 'N/A' }}</h3>
                        <div class="vehicle-specs">
                            <p><strong>Stock #:</strong> {{ str_pad($car->id, 4, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Price:</strong> ${{ number_format($car->price) }}</p>
                            <p><strong>Year:</strong> {{ $car->year }}</p>
                            <p><strong>Make:</strong> {{ $car->brand->name ?? 'N/A' }}</p>
                            <p><strong>Model:</strong> {{ $car->carModel->name ?? 'N/A' }}</p>
                            <p><strong>Color:</strong> {{ $car->color->name ?? 'N/A' }}</p>
                            <p><strong>Mileage:</strong> {{ $car->mileage ? number_format($car->mileage) : 'N/A' }} miles</p>
                            <p><strong>VIN:</strong> {{ $car->vin ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="container">
            <form class="application-form" id="applicationForm" action="{{ route('application.store') }}" method="POST">
                @csrf
                @if($car)
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                @endif
                <!-- Buyer Type Selection -->
                <div class="buyer-type-section">
                    <div class="buyer-tabs">
                        <button type="button" class="buyer-tab active" data-type="buyer">Buyer</button>
                        <button type="button" class="buyer-tab" data-type="co-buyer">Co-Buyer</button>
                    </div>
                    <input type="hidden" name="buyer_type" id="buyerType" value="buyer">
                    <p class="form-note">All fields marked with an asterisk (*) are required</p>
                </div>

                <!-- Personal Information -->
                <section class="form-section">
                    <h2>Personal Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="cell_phone">Cell Phone *</label>
                            <input type="tel" id="cell_phone" name="cell_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="home_phone">Home Phone (Optional)</label>
                            <input type="tel" id="home_phone" name="home_phone">
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth *</label>
                            <input type="text" id="date_of_birth" name="date_of_birth" class="us-date" required 
                                   lang="en" inputmode="numeric" maxlength="10" placeholder="MM/DD/YYYY">
                        </div>
                        <div class="form-group">
                            <label for="ssn">SSN *</label>
                            <input type="text" id="ssn" name="ssn" required placeholder="XXX-XX-XXXX" maxlength="11">
                        </div>
                        <div class="form-group">
                            <label for="driver_license">Driver's License Number</label>
                            <input type="text" id="driver_license" name="driver_license">
                        </div>
                        <div class="form-group">
                            <label for="driver_license_state">Driver's License State</label>
                            <select id="driver_license_state" name="driver_license_state">
                                <option value="">Select State</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="license_issue_date">Driver's License Issue Date</label>
                            <input type="text" id="license_issue_date" name="license_issue_date" class="us-date"
                                   lang="en" inputmode="numeric" maxlength="10" placeholder="MM/DD/YYYY">
                        </div>
                        <div class="form-group">
                            <label for="license_expiry_date">Driver's License Expiry Date</label>
                            <input type="text" id="license_expiry_date" name="license_expiry_date" class="us-date"
                                   lang="en" inputmode="numeric" maxlength="10" placeholder="MM/DD/YYYY">
                        </div>
                        <div class="form-group add-previous-address grid-action-right">
                            <button type="button" class="add-address-btn">
                                <span class="material-symbols-outlined">add</span>
                                Add Previous Address
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Residential Information -->
                <section class="form-section">
                    <h2>Residential Information</h2>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="street_address">Street Address *</label>
                            <input type="text" id="street_address" name="street_address" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State *</label>
                            <select id="state" name="state" required>
                                <option value="">Select State</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Zip Code *</label>
                            <input type="text" id="zip_code" name="zip_code" required maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="housing_type">Housing Type *</label>
                            <select id="housing_type" name="housing_type" required>
                                <option value="">Select Housing Type</option>
                                <option value="own">Own</option>
                                <option value="rent">Rent</option>
                                <option value="live-with-family">Live with Family</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monthly_rent">Monthly Rent/Mortgage Amount *</label>
                            <input type="number" id="monthly_rent" name="monthly_rent" required placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div class="form-group">
                            <label for="years_at_address">Years at Address *</label>
                            <select id="years_at_address" name="years_at_address" required>
                                <option value="">Select Years</option>
                                <option value="less-than-1">Less than 1 year</option>
                                <option value="1-2">1-2 years</option>
                                <option value="3-5">3-5 years</option>
                                <option value="5-10">5-10 years</option>
                                <option value="more-than-10">More than 10 years</option>
                            </select>
                        </div>
                        <div class="form-group grid-col-right">
                            <label for="months_at_address">Months</label>
                            <select id="months_at_address" name="months_at_address">
                                <option value="">Select Months</option>
                                <option value="1">1 month</option>
                                <option value="2">2 months</option>
                                <option value="3">3 months</option>
                                <option value="4">4 months</option>
                                <option value="5">5 months</option>
                                <option value="6">6 months</option>
                                <option value="7">7 months</option>
                                <option value="8">8 months</option>
                                <option value="9">9 months</option>
                                <option value="10">10 months</option>
                                <option value="11">11 months</option>
                            </select>
                        </div>
                    </div>
                    <div class="add-previous-address">
                        <button type="button" class="add-address-btn">
                            <span class="material-symbols-outlined">add</span>
                            Add Previous Address
                        </button>
                    </div>
                </section>

                <!-- Employment Information -->
                <section class="form-section">
                    <h2>Employment Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="employer_name">Employer Name *</label>
                            <input type="text" id="employer_name" name="employer_name" required>
                        </div>
                        <div class="form-group">
                            <label for="job_title">Title/Position *</label>
                            <input type="text" id="job_title" name="job_title" required>
                        </div>
                        <div class="form-group">
                            <label for="employer_phone">Employer Phone Number *</label>
                            <input type="tel" id="employer_phone" name="employer_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="monthly_income">Monthly Gross Income *</label>
                            <input type="number" id="monthly_income" name="monthly_income" required placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div class="form-group">
                            <label for="years_at_job">Years at Job *</label>
                            <select id="years_at_job" name="years_at_job" required>
                                <option value="">Select Years</option>
                                <option value="less-than-1">Less than 1 year</option>
                                <option value="1-2">1-2 years</option>
                                <option value="3-5">3-5 years</option>
                                <option value="5-10">5-10 years</option>
                                <option value="more-than-10">More than 10 years</option>
                            </select>
                        </div>
                        <div class="form-group grid-col-right">
                            <label for="months_at_job">Months</label>
                            <select id="months_at_job" name="months_at_job">
                                <option value="">Select Months</option>
                                <option value="1">1 month</option>
                                <option value="2">2 months</option>
                                <option value="3">3 months</option>
                                <option value="4">4 months</option>
                                <option value="5">5 months</option>
                                <option value="6">6 months</option>
                                <option value="7">7 months</option>
                                <option value="8">8 months</option>
                                <option value="9">9 months</option>
                                <option value="10">10 months</option>
                                <option value="11">11 months</option>
                            </select>
                        </div>
                        <div class="form-group add-previous-employment grid-action-right">
                            <button type="button" class="add-employment-btn">
                                <span class="material-symbols-outlined">add</span>
                                Add Previous Employment
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Interested Vehicle -->
                <section class="form-section">
                    <h2>Interested Vehicle</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="stock_number">Stock Number</label>
                            <input type="text" id="stock_number" name="stock_number" value="{{ $car ? str_pad($car->id, 4, '0', STR_PAD_LEFT) : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_year">Year</label>
                            <input type="text" id="vehicle_year" name="vehicle_year" value="{{ $car ? $car->year : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_make">Make</label>
                            <input type="text" id="vehicle_make" name="vehicle_make" value="{{ $car ? ($car->brand->name ?? 'N/A') : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_model">Model</label>
                            <input type="text" id="vehicle_model" name="vehicle_model" value="{{ $car ? ($car->carModel->name ?? 'N/A') : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_price">Vehicle Price</label>
                            <input type="text" id="vehicle_price" value="{{ $car ? '$' . number_format($car->price) : '$0.00' }}" readonly>
                            <input type="hidden" name="vehicle_price" value="{{ $car ? $car->price : 0 }}">
                        </div>
                        <div class="form-group">
                            <label for="down_payment">Down Payment</label>
                            <input type="number" id="down_payment" name="down_payment" value="{{ $car ? $car->price * 0.1 : 0 }}" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div class="form-group">
                            <label for="exterior_color">Exterior Color</label>
                            <input type="text" id="exterior_color" name="exterior_color" value="{{ $car ? ($car->color->name ?? 'N/A') : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="interior_color">Interior Color</label>
                            <input type="text" id="interior_color" name="interior_color" value="{{ $car ? ($car->interior_color ?? 'N/A') : '' }}">
                        </div>
                    </div>
                    <div class="add-trade-in">
                        <div class="checkbox-group">
                            <input type="checkbox" id="has_trade_in" name="has_trade_in" value="1">
                            <label for="has_trade_in">Add Trade-In?</label>
                        </div>
                    </div>
                </section>

                <!-- Trade-In Section (Hidden by default) -->
                <section class="form-section trade-in-section" style="display: none;">
                    <h2>Trade-In</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="trade_vin">VIN *</label>
                            <input type="text" id="trade_vin" name="trade_vin">
                        </div>
                        <div class="form-group">
                            <label for="trade_mileage">Mileage *</label>
                            <input type="text" id="trade_mileage" name="trade_mileage">
                        </div>
                        <div class="form-group">
                            <label for="trade_year">Year *</label>
                            <input type="text" id="trade_year" name="trade_year">
                        </div>
                        <div class="form-group">
                            <label for="trade_make">Make *</label>
                            <input type="text" id="trade_make" name="trade_make">
                        </div>
                        <div class="form-group">
                            <label for="trade_model">Model *</label>
                            <input type="text" id="trade_model" name="trade_model">
                        </div>
                    </div>
                </section>

                <!-- Terms and Submit -->
                <section class="form-section">
                    <div class="terms-section">
                        <p class="terms-text">
                            By clicking "Submit", I, the undersigned, (a) for the purpose of securing credit, certify the below representations to be correct, (b) 
                            authorize financial institutions, as they consider necessary and appropriate, to obtain consumer credit reports on me periodically 
                            and to gather employment history, and (c) understand that yes, or any financial institution to whom this application is submitted, 
                            will retain this application whether or not it is approved, and that it is the applicant's responsibility to notify the creditor of any 
                            change of name, address, or employment. We and any financial institution to whom this application is submitted, may share certain 
                            non-public personal information about you with your authorization or as provided by law.
                        </p>
                        <br>
                        <p class="terms-text">
                            I consent to be contacted by the dealer at any telephone number or Email I provide, including, without limitation, communications 
                            sent via text message to my cell phone or communications sent using an autodialer or prerecorded message. This 
                            acknowledgment constitutes my written consent to receive such communications. I have read and agree to the Privacy Policy of 
                            this dealer.
                        </p>
                        <div class="checkbox-group">
                            <input type="checkbox" id="accepts_terms" name="accepts_terms" value="1" required>
                            <label for="accepts_terms">I accept all the above terms</label>
                        </div>
                    </div>
                </section>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <span class="btn-text">Submit</span>
                        <span class="btn-loading" style="display: none;">
                            <span class="material-symbols-outlined spinning">refresh</span>
                            Submitting...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </main>

@push('scripts')
    <script src="{{ asset('js/apply-online.js') }}"></script>
@endpush

@endsection
