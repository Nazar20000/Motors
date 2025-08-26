// Функциональность страницы "Подать заявку онлайн"
(function(init) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})(function() {
    const form = document.getElementById('applicationForm');
    const buyerTabs = document.querySelectorAll('.buyer-tab');
    const buyerTypeInput = document.getElementById('buyerType');
    const tradeInCheckbox = document.getElementById('has_trade_in');
    const tradeInSection = document.querySelector('.trade-in-section');
    const submitBtn = document.querySelector('.submit-btn');
    const btnText = document.querySelector('.btn-text');
    const btnLoading = document.querySelector('.btn-loading');
    let previousAddressesContainer = document.getElementById('previous-addresses');
    let previousEmploymentsContainer = document.getElementById('previous-employments');

    // Buyer type tabs functionality
    buyerTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            buyerTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            // Update hidden input
            buyerTypeInput.value = this.dataset.type;
        });
    });

    // Trade-in section toggle
    if (tradeInCheckbox && tradeInSection) {
        tradeInCheckbox.addEventListener('change', function() {
            if (this.checked) {
                tradeInSection.style.display = 'block';
                // Make trade-in fields required
                const tradeInFields = tradeInSection.querySelectorAll('input[type="text"]');
                tradeInFields.forEach(field => {
                    field.required = true;
                });
            } else {
                tradeInSection.style.display = 'none';
                // Remove required from trade-in fields
                const tradeInFields = tradeInSection.querySelectorAll('input[type="text"]');
                tradeInFields.forEach(field => {
                    field.required = false;
                });
            }
        });
    }

    // SSN formatting
    const ssnInput = document.getElementById('ssn');
    if (ssnInput) {
        ssnInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 9) {
                value = value.substring(0, 9);
            }
            if (value.length >= 5) {
                value = value.substring(0, 3) + '-' + value.substring(3, 5) + '-' + value.substring(5);
            } else if (value.length >= 3) {
                value = value.substring(0, 3) + '-' + value.substring(3);
            }
            e.target.value = value;
        });
    }

    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            if (value.length >= 6) {
                value = value.substring(0, 3) + '-' + value.substring(3, 6) + '-' + value.substring(6);
            } else if (value.length >= 3) {
                value = value.substring(0, 3) + '-' + value.substring(3);
            }
            e.target.value = value;
        });
    });

    // Number input formatting for currency fields
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            // Ensure only valid numeric input
            if (value && isNaN(value)) {
                e.target.value = '';
            }
        });
    });

    // Add Previous Address functionality (fix: each button adds near itself; shared indexing across the form)
    const addAddressWrappers = document.querySelectorAll('.add-previous-address');
    if (addAddressWrappers.length) {
        const stateSelect = document.getElementById('state');
        const yearsSelect = document.getElementById('years_at_address');
        const monthsSelect = document.getElementById('months_at_address');
        const stateOptionsHtml = stateSelect ? stateSelect.innerHTML : '<option value="">Select State</option>';
        const yearsOptionsHtml = yearsSelect ? yearsSelect.innerHTML : '';
        const monthsOptionsHtml = monthsSelect ? monthsSelect.innerHTML : '';

        function createPreviousAddressBlock(index) {
            const wrapper = document.createElement('div');
            wrapper.className = 'previous-address-block';
            wrapper.style.marginBottom = '20px';
            wrapper.innerHTML = `
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Previous Street Address *</label>
                        <input type="text" name="previous_addresses[${index}][street_address]" required>
                    </div>
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="previous_addresses[${index}][city]" required>
                    </div>
                    <div class="form-group">
                        <label>State *</label>
                        <select name="previous_addresses[${index}][state]" required>${stateOptionsHtml}</select>
                    </div>
                    <div class="form-group">
                        <label>Zip Code *</label>
                        <input type="text" name="previous_addresses[${index}][zip_code]" required maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>Years at Address *</label>
                        <select name="previous_addresses[${index}][years]" required>${yearsOptionsHtml}</select>
                    </div>
                    <div class="form-group">
                        <label>Months</label>
                        <select name="previous_addresses[${index}][months]">${monthsOptionsHtml}</select>
                    </div>
                </div>
                <div style="margin-top:10px; text-align:right;">
                    <button type="button" class="remove-prev-address" style="background:#dc3545;color:#fff;border:none;padding:8px 12px;border-radius:4px;cursor:pointer;">Remove</button>
                </div>
            `;

            wrapper.querySelector('.remove-prev-address').addEventListener('click', function() {
                wrapper.remove();
            });

            return wrapper;
        }

        function getNextIndex() {
            return document.querySelectorAll('.previous-address-block').length;
        }

        function ensureContainerForWrapper(wrapper) {
            let container = wrapper.previousElementSibling;
            if (!container || !container.classList || !container.classList.contains('previous-addresses-list')) {
                container = document.createElement('div');
                container.className = 'previous-addresses-list';
                container.style.marginTop = '20px';
                wrapper.parentNode.insertBefore(container, wrapper);
            }
            return container;
        }

        addAddressWrappers.forEach(wrapper => {
            const btn = wrapper.querySelector('.add-address-btn');
            if (!btn) return;
            btn.addEventListener('click', function() {
                const container = ensureContainerForWrapper(wrapper);
                const block = createPreviousAddressBlock(getNextIndex());
                container.appendChild(block);
            });
        });
    }

    // Add Previous Employment functionality
    const addEmploymentWrapper = document.querySelector('.add-previous-employment');
    const addEmploymentBtn = addEmploymentWrapper ? addEmploymentWrapper.querySelector('.add-employment-btn') : null;
    if (addEmploymentBtn) {
        if (!previousEmploymentsContainer) {
            previousEmploymentsContainer = document.createElement('div');
            previousEmploymentsContainer.id = 'previous-employments';
            previousEmploymentsContainer.style.marginTop = '20px';
            addEmploymentWrapper.parentNode.insertBefore(previousEmploymentsContainer, addEmploymentWrapper);
        }

        const yearsJobSelect = document.getElementById('years_at_job');
        const monthsJobSelect = document.getElementById('months_at_job');
        const yearsJobOptionsHtml = yearsJobSelect ? yearsJobSelect.innerHTML : '';
        const monthsJobOptionsHtml = monthsJobSelect ? monthsJobSelect.innerHTML : '';

        function attachFormatters(scopeEl) {
            // phone formatter
            scopeEl.querySelectorAll('input[type="tel"]').forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 10) value = value.substring(0, 10);
                    if (value.length >= 6) {
                        value = value.substring(0,3) + '-' + value.substring(3,6) + '-' + value.substring(6);
                    } else if (value.length >= 3) {
                        value = value.substring(0,3) + '-' + value.substring(3);
                    }
                    e.target.value = value;
                });
            });
            // numeric validation
            scopeEl.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function(e) {
                    const val = e.target.value;
                    if (val && isNaN(val)) e.target.value = '';
                });
            });
        }

        function createPreviousEmploymentBlock(index) {
            const wrapper = document.createElement('div');
            wrapper.className = 'previous-employment-block';
            wrapper.style.marginBottom = '20px';
            wrapper.innerHTML = `
                <div class="form-grid">
                    <div class="form-group">
                        <label>Previous Employer Name *</label>
                        <input type="text" name="previous_employments[${index}][employer_name]" required>
                    </div>
                    <div class="form-group">
                        <label>Title/Position *</label>
                        <input type="text" name="previous_employments[${index}][job_title]" required>
                    </div>
                    <div class="form-group">
                        <label>Employer Phone *</label>
                        <input type="tel" name="previous_employments[${index}][employer_phone]" required>
                    </div>
                    <div class="form-group">
                        <label>Monthly Gross Income</label>
                        <input type="number" step="0.01" min="0" name="previous_employments[${index}][monthly_income]" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Years at Job *</label>
                        <select name="previous_employments[${index}][years]" required>${yearsJobOptionsHtml}</select>
                    </div>
                    <div class="form-group">
                        <label>Months</label>
                        <select name="previous_employments[${index}][months]">${monthsJobOptionsHtml}</select>
                    </div>
                </div>
                <div style="margin-top:10px; text-align:right;">
                    <button type="button" class="remove-prev-employment" style="background:#dc3545;color:#fff;border:none;padding:8px 12px;border-radius:4px;cursor:pointer;">Remove</button>
                </div>
            `;

            wrapper.querySelector('.remove-prev-employment').addEventListener('click', function() {
                wrapper.remove();
            });

            attachFormatters(wrapper);
            return wrapper;
        }

        function getNextEmploymentIndex() {
            return previousEmploymentsContainer.querySelectorAll('.previous-employment-block').length;
        }

        addEmploymentBtn.addEventListener('click', function() {
            const block = createPreviousEmploymentBlock(getNextEmploymentIndex());
            previousEmploymentsContainer.appendChild(block);
        });
    }

    // Normalize US date fields for backend validation
    const usDateInputs = document.querySelectorAll('input.us-date');
    usDateInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let v = e.target.value.replace(/[^0-9]/g, '').slice(0, 8);
            if (v.length >= 5) v = v.slice(0,2) + '/' + v.slice(2,4) + '/' + v.slice(4);
            else if (v.length >= 3) v = v.slice(0,2) + '/' + v.slice(2);
            e.target.value = v;
        });
    });

    function normalizeUsDate(mmddyyyy) {
        if (!mmddyyyy) return '';
        const m = mmddyyyy.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
        if (!m) return '';
        const mm = m[1];
        const dd = m[2];
        const yyyy = m[3];
        return `${yyyy}-${mm}-${dd}`;
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            submitBtn.disabled = true;

            // Prepare form data
            const formData = new FormData(form);

            // Normalize US date inputs to ISO for backend
            ['date_of_birth','license_issue_date','license_expiry_date'].forEach(field => {
                const el = document.getElementById(field);
                if (el && el.classList.contains('us-date')) {
                    const iso = normalizeUsDate(el.value);
                    if (iso) formData.set(field, iso);
                }
            });
            
            // Convert checkbox values to boolean
            formData.set('has_trade_in', tradeInCheckbox.checked ? '1' : '0');
            formData.set('accepts_terms', document.getElementById('accepts_terms').checked ? '1' : '0');

            // Send request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Application submitted successfully!', 'success');
                    form.reset();
                    
                    // Reset buyer type
                    if (buyerTabs.length) buyerTabs[0].click();
                    
                    // Hide trade-in section
                    if (tradeInSection) {
                        tradeInSection.style.display = 'none';
                    }
                    if (tradeInCheckbox) tradeInCheckbox.checked = false;

                    // Clear dynamic previous sections
                    document.querySelectorAll('.previous-addresses-list').forEach(c => c.innerHTML = '');
                    if (previousEmploymentsContainer) previousEmploymentsContainer.innerHTML = '';
                    
                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    // Show error message
                    showNotification(data.message || 'An error occurred. Please try again.', 'error');
                    
                    // Show validation errors if any
                    if (data.errors) {
                        showValidationErrors(data.errors);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                // Hide loading state
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                submitBtn.disabled = false;
            });
        });
    }

    // Notification function
    function showNotification(message, type) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-message">${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;

        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: 500;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
        `;

        if (type === 'success') {
            notification.style.backgroundColor = '#28a745';
        } else {
            notification.style.backgroundColor = '#dc3545';
        }

        // Add to page
        document.body.appendChild(notification);

        // Close button functionality
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.remove();
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Show validation errors
    function showValidationErrors(errors) {
        // Clear previous error styling
        const errorFields = document.querySelectorAll('.field-error');
        errorFields.forEach(field => {
            field.classList.remove('field-error');
        });

        // Add error styling to fields with errors
        Object.keys(errors).forEach(fieldName => {
            let field = document.querySelector(`[name="${fieldName}"]`);
            if (!field && fieldName.includes('.')) {
                // Convert dot notation (previous_addresses.0.city) to bracket notation (previous_addresses[0][city])
                const parts = fieldName.split('.');
                const bracketName = parts.slice(1).reduce((acc, part) => acc + `[${part}]`, parts[0]);
                field = document.querySelector(`[name="${bracketName}"]`);
            }
            if (field) {
                field.classList.add('field-error');
                
                // Show error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = errors[fieldName][0];
                errorMessage.style.cssText = `
                    color: #dc3545;
                    font-size: 12px;
                    margin-top: 5px;
                `;
                
                // Remove existing error message
                const existingError = field.parentNode.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                field.parentNode.appendChild(errorMessage);
            }
        });
    }

    // Add CSS for animations
    // (styles moved to CSS; keep classes only)
});

// Force document language to English
document.documentElement.setAttribute('lang', 'en');
document.documentElement.setAttribute('xml:lang', 'en');