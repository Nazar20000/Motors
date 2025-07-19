@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/contact-us.css">
@endpush


@section('content')


    <!-- Contact Us Page -->
    <main class="contact-us-page">
        <div class="page-banner">
            <h1>CONTACT US</h1>
        </div>
        
        <div class="container">
            <section class="contact-hero">
                <div class="contact-info-section">
                    <h2>HOW TO REACH US</h2>
                    <p class="contact-description">
                        If you need help with any aspect of the buying process, please don't hesitate to ask us. 
                        Our customer service representatives will be happy to assist you in any way. Whether 
                        through email, phone or in person, we're here to help you get the customer service you deserve.
                    </p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <span class="material-symbols-outlined">email</span>
                            <a href="mailto:danijela13@gmail.com" class="contact-link">danijela13@gmail.com</a>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined">phone</span>
                            <a href="tel:+12792064797" class="contact-link">(279) 206-4797</a>
                        </div>
                        <div class="contact-item">
                            <span class="material-symbols-outlined">location_on</span>
                            <div class="address-info">
                                <span class="address-line">2400 Fulton Ave, Unit L,</span>
                                <span class="address-line">Sacramento, CA 95825</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hours-info">
                        <div class="hours-item">
                            <strong>Mon-Sat:</strong> 10:00 AM - 7:00 PM
                        </div>
                        <div class="hours-item">
                            <strong>Sun:</strong> 11:00 AM - 4:00 PM
                        </div>
                    </div>
                </div>
                
                <div class="hero-image">
                    <img src="./img/banner.jpg" alt="Yellow Lamborghini" />
                    <div class="image-border"></div>
                </div>
            </section>
            
            <section class="contact-form-section">
                <div class="form-container">
                    <div class="form-header">
                        <h3>Do you have questions or comments for us? We'd love to hear them!</h3>
                        <p>Fill out the form below and we will get back to you as soon as possible.</p>
                        <p class="required-note">All fields marked with an asterisk (*) are required</p>
                    </div>
                    
                    <form class="contact-form" id="contactForm">
                        <div class="form-section">
                            <h4>Contact Information</h4>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="firstName">First Name *</label>
                                    <input type="text" id="firstName" name="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name *</label>
                                    <input type="text" id="lastName" name="lastName" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="contact-preferences">
                                <h5>Contact Preference</h5>
                                <div class="preference-options">
                                    <div class="preference-option">
                                        <input type="checkbox" id="prefPhone" name="contactPreference" value="phone">
                                        <label for="prefPhone">Phone</label>
                                    </div>
                                    <div class="preference-option">
                                        <input type="checkbox" id="prefEmail" name="contactPreference" value="email">
                                        <label for="prefEmail">Email</label>
                                    </div>
                                    <div class="preference-option">
                                        <input type="checkbox" id="prefSMS" name="contactPreference" value="sms">
                                        <label for="prefSMS">SMS</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group full-width">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" rows="6" required placeholder="Please enter your message here..."></textarea>
                                <div class="character-count">
                                    <span id="messageCount">0</span>/1024
                                </div>
                            </div>
                        </div>
                        
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
                
                <div class="map-container">
                    <div class="map-placeholder">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3118.5234567890123!2d-121.4944!3d38.5816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzjCsDM0JzUzLjgiTiAxMjHCsDI5JzM5LjgiVw!5e0!3m2!1sen!2sus!4v1234567890123"
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="BucketBuddy Auto LLC Location">
                        </iframe>
                    </div>
                    <div class="map-info">
                        <h4>BucketBuddy Auto LLC</h4>
                        <p>2400 Fulton Ave Unit L, Sacramento, CA 95825, United States</p>
                        <div class="rating">
                            <span class="stars">★★★★☆</span>
                            <span class="rating-text">4.5 ★★★★★ 243 reviews</span>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="view-larger-map">View larger map</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

@push('scripts')
    <script src="./js/script.js"></script>
    <script src="./js/contact-us.js"></script>
@endpush

@endsection