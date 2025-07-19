@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/car-finder.css">
@endpush


@section('content')

    <!-- Car Finder Page -->
    <main class="car-finder-page">
        <div class="container">
            <div class="page-header">
                <h1>Let us know exactly what you're in the market for and we'll help you find it.</h1>
                <p>All fields marked with an asterisk (*) are required</p>
            </div>

            <form class="car-finder-form" id="carFinderForm">
                <!-- Vehicle Information Section -->
                <section class="form-section">
                    <h2>Vehicle Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="make">Make *</label>
                            <input type="text" id="make" name="make" required placeholder="Enter make">
                        </div>
                        <div class="form-group">
                            <label for="model">Model *</label>
                            <input type="text" id="model" name="model" required placeholder="Enter model">
                        </div>
                        <div class="form-group">
                            <label for="year">Year *</label>
                            <input type="text" id="year" name="year" required placeholder="Enter year">
                        </div>
                        <div class="form-group">
                            <label for="maxMileage">Max Mileage *</label>
                            <input type="text" id="maxMileage" name="maxMileage" required placeholder="Enter max mileage">
                        </div>
                        <div class="form-group full-width">
                            <label for="priceRange">Price Range *</label>
                            <select id="priceRange" name="priceRange" required>
                                <option value="">Select price range</option>
                                <option value="under-20k">Under $20,000</option>
                                <option value="20k-40k">$20,000 - $40,000</option>
                                <option value="40k-60k">$40,000 - $60,000</option>
                                <option value="60k-80k">$60,000 - $80,000</option>
                                <option value="over-80k">Over $80,000</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label for="desiredFeatures">Desired Features</label>
                            <textarea id="desiredFeatures" name="desiredFeatures" rows="4" placeholder="Tell us about any specific features you're looking for..."></textarea>
                            <div class="character-count">
                                <span id="featuresCount">0</span>/1024
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Information Section -->
                <section class="form-section">
                    <h2>Contact Information</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" name="firstName" required placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" required placeholder="Enter last name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="Enter phone number">
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required placeholder="Enter email address">
                        </div>
                        <div class="form-group full-width">
                            <label for="comments">Comments</label>
                            <textarea id="comments" name="comments" rows="4" placeholder="Any additional comments or questions..."></textarea>
                            <div class="character-count">
                                <span id="commentsCount">0</span>/1024
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Terms and Conditions -->
                <section class="form-section">
                    <div class="terms-section">
                        <p class="terms-text">
                            By checking this box and by clicking the "SUBMIT" button below, I consent to receive information by email, 
                            telephone call, including those made with an automatic telephone dialing system or an artificial or prerecorded 
                            voice and/or SMS message from or on behalf of this dealership, and/or their representatives at any contact 
                            information I provide above, even if I am on a state or federal Do-Not-Call list. I understand that calls and 
                            messages to any mobile phone number may incur access fees from my cellular provider. This acknowledgment 
                            constitutes my written consent to receive such communications. I have read and agree to the Privacy Policy of 
                            this dealership.
                        </p>
                        <div class="checkbox-group">
                            <input type="checkbox" id="acceptTerms" name="acceptTerms" required>
                            <label for="acceptTerms">I accept all the above terms</label>
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
    <script src="./js/script.js"></script>
    <script src="./js/car-finder.js"></script>
@endpush

@endsection