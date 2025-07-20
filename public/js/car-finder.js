// Car Finder page functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('carFinderForm');
    const submitBtn = form.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    // Character count functionality
    const textareas = form.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = 1024;
        const countElement = textarea.parentElement.querySelector('.character-count span');
        
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            countElement.textContent = currentLength;
            
            const countContainer = countElement.parentElement;
            countContainer.classList.remove('warning', 'error');
            
            if (currentLength > maxLength * 0.9) {
                countContainer.classList.add('warning');
            }
            if (currentLength > maxLength) {
                countContainer.classList.add('error');
                this.value = this.value.substring(0, maxLength);
                countElement.textContent = maxLength;
            }
        });
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
        }
        this.value = value;
    });
    
    // Year input validation
    const yearInput = document.getElementById('year');
    yearInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 4) {
            this.value = this.value.substring(0, 4);
        }
    });
    
    // Mileage input formatting
    const mileageInput = document.getElementById('maxMileage');
    mileageInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            value = parseInt(value).toLocaleString();
        }
        this.value = value;
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
        
        // Year validation
        if (field.id === 'year' && field.value) {
            const year = parseInt(field.value);
            const currentYear = new Date().getFullYear();
            if (year < 1900 || year > currentYear + 1) {
                isValid = false;
                errorMessage = `Please enter a year between 1900 and ${currentYear + 1}`;
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
        requiredFields.forEach(field => {
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
            
            // Reset form
            form.reset();
            
            // Remove validation classes
            const validatedGroups = form.querySelectorAll('.form-group.error, .form-group.success');
            validatedGroups.forEach(group => {
                group.classList.remove('error', 'success');
                const messages = group.querySelectorAll('.error-message, .success-message');
                messages.forEach(msg => msg.remove());
            });
            
            // Reset character counts
            textareas.forEach(textarea => {
                const countElement = textarea.parentElement.querySelector('.character-count span');
                if (countElement) {
                    countElement.textContent = '0';
                    countElement.parentElement.classList.remove('warning', 'error');
                }
            });
            
        }, 2000);
    });
    
    function showSuccessModal() {
        const modal = document.createElement('div');
        modal.className = 'success-modal';
        modal.innerHTML = `
            <div class="success-modal-content">
                <div class="success-icon">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <h2>Request Submitted Successfully!</h2>
                <p>Thank you for your interest! Our team will review your request and contact you within 24 hours with available vehicles that match your criteria.</p>
                <button onclick="this.closest('.success-modal').remove()">Close</button>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Show modal with animation
        setTimeout(() => {
            modal.classList.add('active');
        }, 100);
        
        // Auto close after 5 seconds
        setTimeout(() => {
            if (modal.parentElement) {
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.remove();
                }, 300);
            }
        }, 5000);
        
        // Close on backdrop click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.remove();
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
    
    // Auto-save functionality (optional)
    let autoSaveTimeout;
    const formInputs = form.querySelectorAll('input, select, textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                saveFormData();
            }, 1000);
        });
    });
    
    function saveFormData() {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        localStorage.setItem('carFinderFormData', JSON.stringify(data));
    }
    
    function loadFormData() {
        const savedData = localStorage.getItem('carFinderFormData');
        if (savedData) {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field && data[key]) {
                    field.value = data[key];
                    if (field.type === 'checkbox') {
                        field.checked = data[key] === 'on';
                    }
                }
            });
        }
    }
    
    // Load saved data on page load
    loadFormData();
    
    // Clear saved data on successful submission
    form.addEventListener('submit', function() {
        setTimeout(() => {
            localStorage.removeItem('carFinderFormData');
        }, 2000);
    });
    
    console.log('Car Finder page - All scripts loaded successfully');
});