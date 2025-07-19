@extends('layout.app')

@section('title-block')
    Главная
@endsection

@push('styles')
    <title>Apply Online - Bucket Buddy Auto LLC</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/apply-online.css">
@endpush


@section('content')


    <!-- Apply Online Page -->
    <main class="apply-online-page">
        <div class="page-banner">
            <h1>APPLY ONLINE</h1>
        </div>
        
        <div class="container">
            <form class="application-form" id="applicationForm">
                <!-- Buyer Type Selection -->
                <div class="buyer-type-section">
                    <div class="buyer-tabs">
                        <button type="button" class="buyer-tab active" data-type="buyer">Buyer</button>
                        <button type="button" class="buyer-tab" data-type="co-buyer">Co-Buyer</button>
                    </div>
                    <p class="form-note">All fields marked with an asterisk (*) are required</p>
                </div>

                <!-- Personal Information -->
                <section class="form-section">
                    <h2>Personal Information</h2>
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
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="cellPhone">Cell Phone *</label>
                            <input type="tel" id="cellPhone" name="cellPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="homePhone">Home Phone (Optional)</label>
                            <input type="tel" id="homePhone" name="homePhone">
                        </div>
                        <div class="form-group">
                            <label for="dateOfBirth">Date of Birth *</label>
                            <input type="date" id="dateOfBirth" name="dateOfBirth" required>
                        </div>
                        <div class="form-group">
                            <label for="ssn">SSN *</label>
                            <input type="text" id="ssn" name="ssn" required placeholder="XXX-XX-XXXX" maxlength="11">
                        </div>
                        <div class="form-group">
                            <label for="driverLicense">Driver's License Number</label>
                            <input type="text" id="driverLicense" name="driverLicense">
                        </div>
                        <div class="form-group">
                            <label for="driverLicenseState">Driver's License State</label>
                            <select id="driverLicenseState" name="driverLicenseState">
                                <option value="">Select State</option>
                                <option value="CA">California</option>
                                <option value="NY">New York</option>
                                <option value="TX">Texas</option>
                                <option value="FL">Florida</option>
                                <!-- Add more states as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="licenseIssueDate">Driver's License Issue Date</label>
                            <input type="date" id="licenseIssueDate" name="licenseIssueDate">
                        </div>
                        <div class="form-group">
                            <label for="licenseExpiryDate">Driver's License Expiry Date</label>
                            <input type="date" id="licenseExpiryDate" name="licenseExpiryDate">
                        </div>
                    </div>
                </section>

                <!-- Residential Information -->
                <section class="form-section">
                    <h2>Residential Information</h2>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="streetAddress">Street Address *</label>
                            <input type="text" id="streetAddress" name="streetAddress" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State *</label>
                            <select id="state" name="state" required>
                                <option value="">Select State</option>
                                <option value="CA">California</option>
                                <option value="NY">New York</option>
                                <option value="TX">Texas</option>
                                <option value="FL">Florida</option>
                                <!-- Add more states -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="zipCode">Zip Code *</label>
                            <input type="text" id="zipCode" name="zipCode" required maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="housingType">Housing Type *</label>
                            <select id="housingType" name="housingType" required>
                                <option value="">Select Housing Type</option>
                                <option value="own">Own</option>
                                <option value="rent">Rent</option>
                                <option value="live-with-family">Live with Family</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monthlyRent">Monthly Rent/Mortgage Amount *</label>
                            <input type="text" id="monthlyRent" name="monthlyRent" required placeholder="$0.00">
                        </div>
                        <div class="form-group">
                            <label for="yearsAtAddress">Years at Address *</label>
                            <select id="yearsAtAddress" name="yearsAtAddress" required>
                                <option value="">Select Years</option>
                                <option value="less-than-1">Less than 1 year</option>
                                <option value="1-2">1-2 years</option>
                                <option value="3-5">3-5 years</option>
                                <option value="5-10">5-10 years</option>
                                <option value="more-than-10">More than 10 years</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monthsAtAddress">Months</label>
                            <select id="monthsAtAddress" name="monthsAtAddress">
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
                            <label for="employerName">Employer Name *</label>
                            <input type="text" id="employerName" name="employerName" required>
                        </div>
                        <div class="form-group">
                            <label for="jobTitle">Title/Position *</label>
                            <input type="text" id="jobTitle" name="jobTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="employerPhone">Employer Phone Number *</label>
                            <input type="tel" id="employerPhone" name="employerPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="monthlyIncome">Monthly Gross Income *</label>
                            <input type="text" id="monthlyIncome" name="monthlyIncome" required placeholder="$0.00">
                        </div>
                        <div class="form-group">
                            <label for="yearsAtJob">Years at Job *</label>
                            <select id="yearsAtJob" name="yearsAtJob" required>
                                <option value="">Select Years</option>
                                <option value="less-than-1">Less than 1 year</option>
                                <option value="1-2">1-2 years</option>
                                <option value="3-5">3-5 years</option>
                                <option value="5-10">5-10 years</option>
                                <option value="more-than-10">More than 10 years</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monthsAtJob">Months</label>
                            <select id="monthsAtJob" name="monthsAtJob">
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
                    <div class="add-previous-employment">
                        <button type="button" class="add-employment-btn">
                            <span class="material-symbols-outlined">add</span>
                            Add Previous Employment
                        </button>
                    </div>
                </section>

                <!-- Interested Vehicle -->
                <section class="form-section">
                    <h2>Interested Vehicle</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="stockNumber">Stock Number</label>
                            <input type="text" id="stockNumber" name="stockNumber">
                        </div>
                        <div class="form-group">
                            <label for="vehicleYear">Year</label>
                            <input type="text" id="vehicleYear" name="vehicleYear">
                        </div>
                        <div class="form-group">
                            <label for="vehicleMake">Make</label>
                            <input type="text" id="vehicleMake" name="vehicleMake">
                        </div>
                        <div class="form-group">
                            <label for="vehicleModel">Model</label>
                            <input type="text" id="vehicleModel" name="vehicleModel">
                        </div>
                        <div class="form-group">
                            <label for="vehiclePrice">Vehicle Price</label>
                            <input type="text" id="vehiclePrice" name="vehiclePrice" placeholder="$0.00">
                        </div>
                        <div class="form-group">
                            <label for="downPayment">Down Payment</label>
                            <input type="text" id="downPayment" name="downPayment" placeholder="$0.00">
                        </div>
                        <div class="form-group">
                            <label for="exteriorColor">Exterior Color</label>
                            <input type="text" id="exteriorColor" name="exteriorColor">
                        </div>
                        <div class="form-group">
                            <label for="interiorColor">Interior Color</label>
                            <input type="text" id="interiorColor" name="interiorColor">
                        </div>
                    </div>
                    <div class="add-trade-in">
                        <div class="checkbox-group">
                            <input type="checkbox" id="addTradeIn" name="addTradeIn">
                            <label for="addTradeIn">Add Trade-In?</label>
                        </div>
                    </div>
                </section>

                <!-- Trade-In Section (Hidden by default) -->
                <section class="form-section trade-in-section" style="display: none;">
                    <h2>Trade-In</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="tradeVin">VIN *</label>
                            <input type="text" id="tradeVin" name="tradeVin">
                        </div>
                        <div class="form-group">
                            <label for="tradeMileage">Mileage *</label>
                            <input type="text" id="tradeMileage" name="tradeMileage">
                        </div>
                        <div class="form-group">
                            <label for="tradeYear">Year *</label>
                            <input type="text" id="tradeYear" name="tradeYear">
                        </div>
                        <div class="form-group">
                            <label for="tradeMake">Make *</label>
                            <input type="text" id="tradeMake" name="tradeMake">
                        </div>
                        <div class="form-group">
                            <label for="tradeModel">Model *</label>
                            <input type="text" id="tradeModel" name="tradeModel">
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
    <script src="./js/apply-online.js"></script>
@endpush

@endsection