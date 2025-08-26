// Vehicle Detail Page JavaScript

let vehicleDetailImageIndex = 0;
let images = [];
let carId = null;
let carPrice = 0;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeGallery();
    initializeButtons();
    loadCarData();
    initializeCalculator();
});

function loadCarData() {
    const carDataElement = document.getElementById('carData');
    if (carDataElement) {
        carId = carDataElement.dataset.carId;
        carPrice = parseFloat(carDataElement.dataset.carPrice) || 0;
        const mainImage = carDataElement.dataset.mainImage;
        const additionalImages = JSON.parse(carDataElement.dataset.images || '[]');
        
        images = [mainImage, ...additionalImages];
        updateImageCounter();
        updateIndicators();
        updateNavigationButtons();
    }
}

function initializeGallery() {
    // Get all images (main image + additional images)
    const mainImage = document.getElementById('mainCarImage');
    if (mainImage) {
        images.push(mainImage.src);
    }
    
    // Add additional images if they exist
    const additionalImages = document.querySelectorAll('.car-thumb');
    additionalImages.forEach(img => {
        if (img.dataset.full) {
            images.push(img.dataset.full);
        }
    });
    
    updateImageCounter();
    updateIndicators();
    updateNavigationButtons();
}

function initializeButtons() {
    // Back button
    const backBtn = document.querySelector('.back-btn');
    if (backBtn) {
        backBtn.addEventListener('click', () => {
            history.back();
        });
    }
    
    // Action buttons
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Check if this is the APPLY ONLINE button (link)
            if (this.classList.contains('apply-online') && this.tagName === 'A') {
                // Allow the link to work normally
                console.log('APPLY ONLINE link clicked - allowing navigation');
                return; // Don't prevent default for links
            }
            
            // Check if this is the SCHEDULE TEST DRIVE button
            if (this.classList.contains('schedule-test-drive')) {
                e.preventDefault();
                openTestDriveModal();
                return;
            }
            
            e.preventDefault();
            // Add your action logic here
            console.log('Action button clicked:', this.textContent);
        });
    });
    
    // Sticker button
    const stickerBtn = document.querySelector('.sticker-btn');
    if (stickerBtn) {
        stickerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showSticker();
        });
    }
    
    // Personalize button
    const personalizeBtn = document.querySelector('.personalize-btn');
    if (personalizeBtn) {
        personalizeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            personalizePayments();
        });
    }
    
    // Floating contact button
    const floatingContactBtn = document.querySelector('.floating-contact-btn');
    if (floatingContactBtn) {
        floatingContactBtn.addEventListener('click', function(e) {
            e.preventDefault();
            contactUs();
        });
    }
}

function initializeCalculator() {
    // Add event listeners for calculator inputs
    const downPaymentInput = document.getElementById('downPayment');
    const interestRateInput = document.getElementById('interestRate');
    const loanTermSelect = document.getElementById('loanTerm');
    
    if (downPaymentInput) {
        downPaymentInput.addEventListener('input', calculatePayment);
    }
    
    if (interestRateInput) {
        interestRateInput.addEventListener('input', calculatePayment);
    }
    
    if (loanTermSelect) {
        loanTermSelect.addEventListener('change', calculatePayment);
    }
    
    // Initial calculation
    calculatePayment();
}

function previousImage() {
    if (images.length > 1) {
        vehicleDetailImageIndex = (vehicleDetailImageIndex - 1 + images.length) % images.length;
        updateMainImage();
        updateIndicators();
        updateImageCounter();
        updateNavigationButtons();
    }
}

function nextImage() {
    if (images.length > 1) {
        vehicleDetailImageIndex = (vehicleDetailImageIndex + 1) % images.length;
        updateMainImage();
        updateIndicators();
        updateImageCounter();
        updateNavigationButtons();
    }
}

function goToImage(index) {
    if (index >= 0 && index < images.length) {
        vehicleDetailImageIndex = index;
        updateMainImage();
        updateIndicators();
        updateImageCounter();
        updateNavigationButtons();
    }
}

function updateMainImage() {
    const mainImage = document.getElementById('mainCarImage');
    if (mainImage && images[vehicleDetailImageIndex]) {
        mainImage.src = images[vehicleDetailImageIndex];
    }
}

function updateIndicators() {
    const indicators = document.querySelectorAll('.indicator');
    indicators.forEach((indicator, index) => {
        if (index === vehicleDetailImageIndex) {
            indicator.classList.add('active');
        } else {
            indicator.classList.remove('active');
        }
    });
}

function updateImageCounter() {
    const counter = document.querySelector('.image-counter');
    if (counter) {
        counter.textContent = `${vehicleDetailImageIndex + 1}/${images.length}`;
    }
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (prevBtn) {
        prevBtn.disabled = images.length <= 1;
    }
    
    if (nextBtn) {
        nextBtn.disabled = images.length <= 1;
    }
}

// Payment Calculator Functions
function togglePaymentCalculator() {
    const calculator = document.getElementById('paymentCalculator');
    
    console.log('togglePaymentCalculator called');
    console.log('Calculator element:', calculator);
    
    if (calculator) {
        if (calculator.style.display === 'none') {
            calculator.style.display = 'block';
            console.log('Calculator opened');
            calculatePayment();
        } else {
            calculator.style.display = 'none';
            console.log('Calculator closed');
        }
    } else {
        console.error('Calculator element not found!');
    }
}

function calculatePayment() {
    const carPrice = parseFloat(document.getElementById('carData').dataset.carPrice) || 0;
    const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
    const interestRate = parseFloat(document.getElementById('interestRate').value) || 7.29;
    const loanTerm = parseInt(document.getElementById('loanTerm').value) || 60;
    
    const loanAmount = carPrice - downPayment;
    const monthlyRate = interestRate / 100 / 12;
    
    let monthlyPayment = 0;
    let totalInterest = 0;
    
    if (monthlyRate > 0 && loanTerm > 0) {
        // Calculate monthly payment using loan formula
        monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm)) / 
                        (Math.pow(1 + monthlyRate, loanTerm) - 1);
        
        // Calculate total interest
        totalInterest = (monthlyPayment * loanTerm) - loanAmount;
    } else {
        // Simple calculation without interest
        monthlyPayment = loanAmount / loanTerm;
        totalInterest = 0;
    }
    
    const totalCost = downPayment + (monthlyPayment * loanTerm);
    
    // Update display
    updateCalculatorResults(monthlyPayment, totalInterest, totalCost);
}

function updateCalculatorResults(monthlyPayment, totalInterest, totalCost) {
    const monthlyPaymentElement = document.getElementById('monthlyPayment');
    const totalInterestElement = document.getElementById('totalInterest');
    const totalCostElement = document.getElementById('totalCost');
    
    if (monthlyPaymentElement) {
        monthlyPaymentElement.textContent = `$${Math.round(monthlyPayment).toLocaleString()}`;
    }
    
    if (totalInterestElement) {
        totalInterestElement.textContent = `$${Math.round(totalInterest)}`;
    }
    
    if (totalCostElement) {
        totalCostElement.textContent = `$${Math.round(totalCost).toLocaleString()}`;
    }
}

// Action Functions
function toggleFavorite() {
    const favoriteBtn = document.querySelector('.favorite-btn');
    if (favoriteBtn) {
        favoriteBtn.classList.toggle('active');
        const isActive = favoriteBtn.classList.contains('active');
        
        if (isActive) {
            showNotification('Added to favorites!', 'success');
        } else {
            showNotification('Removed from favorites!', 'info');
        }
    }
}

function shareVehicle() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('Link copied to clipboard!', 'success');
        });
    }
}

function showSticker() {
    showNotification('Window sticker feature coming soon!', 'info');
}

function confirmAvailability() {
    showNotification('Checking availability...', 'info');
    // Simulate API call
    setTimeout(() => {
        showNotification('Vehicle is available! Contact us to schedule a test drive.', 'success');
    }, 2000);
}

function personalizePayments() {
    togglePaymentCalculator();
    showNotification('Payment calculator opened!', 'info');
}

function showCalculationInfo() {
    showNotification('Payment estimates are based on current market rates and your credit profile. Rates may vary based on credit score and down payment amount.', 'info');
}

function contactUs() {
    // You can integrate with your preferred contact method
    const phone = '609-584-4777';
    const message = `Hi! I'm interested in the ${document.title}`;
    
    // Try to open WhatsApp or SMS
    const whatsappUrl = `https://wa.me/1${phone.replace(/\D/g, '')}?text=${encodeURIComponent(message)}`;
    const smsUrl = `sms:${phone}?body=${encodeURIComponent(message)}`;
    
    // Try WhatsApp first, fallback to SMS
    window.open(whatsappUrl, '_blank');
}

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <span class="notification-message">${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <span class="material-symbols-outlined">close</span>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff'};
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        animation: slideIn 0.3s ease;
    `;
    
    // Add keyframe animation
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        previousImage();
    } else if (e.key === 'ArrowRight') {
        nextImage();
    } else if (e.key === 'Escape') {
        // Close calculator or go back
        const calculator = document.getElementById('paymentCalculator');
        if (calculator && calculator.style.display !== 'none') {
            togglePaymentCalculator();
        } else {
            history.back();
        }
    }
});

// Touch/swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

document.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
});

document.addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next image
            nextImage();
        } else {
            // Swipe right - previous image
            previousImage();
        }
    }
}

// Preload images for better performance
function preloadImages() {
    images.forEach(src => {
        const img = new Image();
        img.src = src;
    });
}

// Initialize image preloading
setTimeout(preloadImages, 1000);

// Test Drive Modal Functions
function openTestDriveModal() {
    const modal = document.getElementById('testDriveModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
        // Set minimum date to today
        const dateInput = document.getElementById('testDriveDate');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }
    }
}

function closeTestDriveModal() {
    const modal = document.getElementById('testDriveModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
}

function submitTestDriveForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Add car information to form data
    formData.append('car_id', carId);
    formData.append('car_price', carPrice);
    formData.append('type', 'test_drive');
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Submit form data
    fetch('/contact-request', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Test drive request submitted successfully! We will contact you soon.', 'success');
            closeTestDriveModal();
            form.reset();
        } else {
            showNotification('Error submitting request. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error submitting request. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('testDriveModal');
    if (event.target === modal) {
        closeTestDriveModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeTestDriveModal();
    }
});