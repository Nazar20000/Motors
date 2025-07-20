// Apply Online page functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('applicationForm');
    const submitBtn = form.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    // Buyer type tabs
    const buyerTabs = document.querySelectorAll('.buyer-tab');
    buyerTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            buyerTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const phoneInputs = form.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
            }
            this.value = value;
        });
    });

    const ssnInput = document.getElementById('ssn');
    ssnInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 5) {
            value = value.replace(/(\d{3})(\d{2})(\d{4})/, '$1-$2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{3})(\d{0,2})/, '$1-$2');
        }
        this.value = value;
    });
    
    // Currency formatting
    const currencyInputs = form.querySelectorAll('input[placeholder*="$"]');
    currencyInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/[^\d.]/g, '');
            if (value) {
                // Ensure only one decimal point
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                // Limit to 2 decimal places
                if (parts[1] && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].substring(0, 2);
                }
                // Format with commas
                const numValue = parseFloat(value);
                if (!isNaN(numValue)) {
                    this.value = '$' + numValue.toLocaleString('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    });
                }
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.value && !this.value.startsWith('$')) {
                const numValue = parseFloat(this.value.replace(/[^\d.]/g, ''));
                if (!isNaN(numValue)) {
                    this.value = '$' + numValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }
        });
    });
    
    // Zip code formatting
    const zipInput = document.getElementById('zipCode');
    zipInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 5) {
            value = value.replace(/(\d{5})(\d{4})/, '$1-$2');
        }
        this.value = value;
    });
    
    // Trade-in toggle
    const addTradeInCheckbox = document.getElementById('addTradeIn');
    const tradeInSection = document.querySelector('.trade-in-section');
    
    addTradeInCheckbox.addEventListener('change', function() {
        if (this.checked) {
            tradeInSection.style.display = 'block';
            // Make trade-in fields required
            const tradeInInputs = tradeInSection.querySelectorAll('input[required]');
            tradeInInputs.forEach(input => input.required = true);
        } else {
            tradeInSection.style.display = 'none';
            // Remove required attribute from trade-in fields
            const tradeInInputs = tradeInSection.querySelectorAll('input');
            tradeInInputs.forEach(input => {
                input.required = false;
                input.value = '';
            });
        }
    });
    
    // Add previous address functionality
    const addAddressBtn = document.querySelector('.add-address-btn');
    let addressCount = 0;
    
    addAddressBtn.addEventListener('click', function() {
        addressCount++;
        const addressSection = document.querySelector('.form-section:has(.add-previous-address)');
        const newAddressHTML = `
            <div class="previous-address" data-address="${addressCount}">
                <h3>Previous Address ${addressCount}</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="prevStreetAddress${addressCount}">Street Address *</label>
                        <input type="text" id="prevStreetAddress${addressCount}" name="prevStreetAddress${addressCount}" required>
                    </div>
                    <div class="form-group">
                        <label for="prevCity${addressCount}">City *</label>
                        <input type="text" id="prevCity${addressCount}" name="prevCity${addressCount}" required>
                    </div>
                    <div class="form-group">
                        <label for="prevState${addressCount}">State *</label>
                        <select id="prevState${addressCount}" name="prevState${addressCount}" required>
                            <option value="">Select State</option>
                            <option value="CA">California</option>
                            <option value="NY">New York</option>
                            <option value="TX">Texas</option>
                            <option value="FL">Florida</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prevZipCode${addressCount}">Zip Code *</label>
                        <input type="text" id="prevZipCode${addressCount}" name="prevZipCode${addressCount}" required maxlength="10">
                    </div>
                </div>
                <button type="button" class="remove-address-btn" onclick="removeAddress(${addressCount})">
                    <span class="material-symbols-outlined">remove</span>
                    Remove Address
                </button>
            </div>
        `;
        
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newAddressHTML;
        addressSection.insertBefore(tempDiv.firstElementChild, addressSection.querySelector('.add-previous-address'));
    });
    
    // Add previous employment functionality
    const addEmploymentBtn = document.querySelector('.add-employment-btn');
    let employmentCount = 0;
    
    addEmploymentBtn.addEventListener('click', function() {
        employmentCount++;
        const employmentSection = document.querySelector('.form-section:has(.add-previous-employment)');
        const newEmploymentHTML = `
            <div class="previous-employment" data-employment="${employmentCount}">
                <h3>Previous Employment ${employmentCount}</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="prevEmployerName${employmentCount}">Employer Name *</label>
                        <input type="text" id="prevEmployerName${employmentCount}" name="prevEmployerName${employmentCount}" required>
                    </div>
                    <div class="form-group">
                        <label for="prevJobTitle${employmentCount}">Title/Position *</label>
                        <input type="text" id="prevJobTitle${employmentCount}" name="prevJobTitle${employmentCount}" required>
                    </div>
                    <div class="form-group">
                        <label for="prevEmployerPhone${employmentCount}">Employer Phone *</label>
                        <input type="tel" id="prevEmployerPhone${employmentCount}" name="prevEmployerPhone${employmentCount}" required>
                    </div>
                    <div class="form-group">
                        <label for="prevMonthlyIncome${employmentCount}">Monthly Income *</label>
                        <input type="text" id="prevMonthlyIncome${employmentCount}" name="prevMonthlyIncome${employmentCount}" required placeholder="$0.00">
                    </div>
                </div>
                <button type="button" class="remove-employment-btn" onclick="removeEmployment(${employmentCount})">
                    <span class="material-symbols-outlined">remove</span>
                    Remove Employment
                </button>
            </div>
        `;
        
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newEmploymentHTML;
        employmentSection.insertBefore(tempDiv.firstElementChild, employmentSection.querySelector('.add-previous-employment'));
        
        // Apply formatting to new currency inputs
        const newCurrencyInputs = tempDiv.querySelectorAll('input[placeholder*="$"]');
        newCurrencyInputs.forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value.replace(/[^\d.]/g, '');
                if (value) {
                    const parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts.slice(1).join('');
                    }
                    if (parts[1] && parts[1].length > 2) {
                        value = parts[0] + '.' + parts[1].substring(0, 2);
                    }
                    const numValue = parseFloat(value);
                    if (!isNaN(numValue)) {
                        this.value = '$' + numValue.toLocaleString('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 2
                        });
                    }
                }
            });
        });
        
        // Apply phone formatting to new phone inputs
        const newPhoneInputs = tempDiv.querySelectorAll('input[type="tel"]');
        newPhoneInputs.forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length >= 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                } else if (value.length >= 3) {
                    value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
                }
                this.value = value;
            });
        });
    });
    
    // Real-time validation
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        const formGroup = field.closest('.form-group');
        const existingError = formGroup.querySelector('.error-message');
        const existingSuccess = formGroup.querySelector('.success-message');
        
        // Remove existing messages
        if (existingError) existingError.remove();
        if (existingSuccess) existingSuccess.remove();
        formGroup.classList.remove('error', 'success');
        
        let isValid = true;
        let errorMessage = '';
        
        // Check if field is empty
        if (field.hasAttribute('required') && !field.value.trim()) {
            isValid = false;
            errorMessage = 'This field is required';
        }
        
        // Email validation
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }
        
        // Phone validation
        if (field.type === 'tel' && field.value) {
            const phoneRegex = /^$$\d{3}$$ \d{3}-\d{4}$/;
            if (!phoneRegex.test(field.value)) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number';
            }
        }
        
        // SSN validation
        if (field.id === 'ssn' && field.value) {
            const ssnRegex = /^\d{3}-\d{2}-\d{4}$/;
            if (!ssnRegex.test(field.value)) {
                isValid = false;
                errorMessage = 'Please enter a valid SSN (XXX-XX-XXXX)';
            }
        }
        
        // Date validation
        if (field.type === 'date' && field.value) {
            const date = new Date(field.value);
            const today = new Date();
            
            if (field.id === 'dateOfBirth') {
                const age = today.getFullYear() - date.getFullYear();
                if (age < 18 || age > 100) {
                    isValid = false;
                    errorMessage = 'You must be between 18 and 100 years old';
                }
            }
        }
        
        // Display validation result
        if (!isValid) {
            formGroup.classList.add('error');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `<span class="material-symbols-outlined">error</span>${errorMessage}`;
            formGroup.appendChild(errorDiv);
        } else if (field.value.trim()) {
            formGroup.classList.add('success');
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message';
            successDiv.innerHTML = `<span class="material-symbols-outlined">check_circle</span>Valid`;
            formGroup.appendChild(successDiv);
        }
        
        return isValid;
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all required fields
        let isFormValid = true;
        const allRequiredFields = form.querySelectorAll('[required]');
        allRequiredFields.forEach(field => {
            if (!validateField(field)) {
                isFormValid = false;
            }
        });
        
        // Check terms acceptance
        const termsCheckbox = document.getElementById('acceptTerms');
        if (!termsCheckbox.checked) {
            isFormValid = false;
            showNotification('Please accept the terms and conditions', 'error');
        }
        
        if (!isFormValid) {
            showNotification('Please correct the errors in the form', 'error');
            // Scroll to first error
            const firstError = form.querySelector('.form-group.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        
        // Simulate form submission
        setTimeout(() => {
            // Reset button state
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            
            // Show success modal
            showSuccessModal();
            
        }, 3000);
    });
    
    function showSuccessModal() {
        const modal = document.createElement('div');
        modal.className = 'success-modal';
        modal.innerHTML = `
            <div class="success-modal-content">
                <div class="success-icon">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <h2>Application Submitted Successfully!</h2>
                <p>Thank you for your application! Our finance team will review your information and contact you within 24 hours with pre-approval details and next steps.</p>
                <button onclick="this.closest('.success-modal').remove(); window.location.href='index.html'">Return to Home</button>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Show modal with animation
        setTimeout(() => {
            modal.classList.add('active');
        }, 100);
        
        // Close on backdrop click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.remove();
                    window.location.href = 'index.html';
                }, 300);
            }
        });
    }
    
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span class="material-symbols-outlined">
                ${type === 'success' ? 'check_circle' : 
                  type === 'warning' ? 'warning' : 
                  type === 'error' ? 'error' : 'info'}
            </span>
            <span>${message}</span>
        `;
        
        // Add notification styles
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? '#4CAF50' : 
                       type === 'warning' ? '#FF9800' : 
                       type === 'error' ? '#F44336' : '#2196F3'};
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            max-width: 400px;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 4000);
    }
    
    console.log('Apply Online page - All scripts loaded successfully');
});

// Global functions for removing dynamic sections
function removeAddress(addressId) {
    const addressSection = document.querySelector(`[data-address="${addressId}"]`);
    if (addressSection) {
        addressSection.remove();
    }
}

function removeEmployment(employmentId) {
    const employmentSection = document.querySelector(`[data-employment="${employmentId}"]`);
    if (employmentSection) {
        employmentSection.remove();
    }
}