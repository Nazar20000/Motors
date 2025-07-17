// Main JavaScript functionality - FIXED VERSION
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuBtn && nav) {
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenuBtn.contains(e.target) && !nav.contains(e.target)) {
                nav.classList.remove('active');
            }
        });
        
        // Close mobile menu when clicking on a link
        const navLinks = nav.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
            });
        });
    }

    // Search form functionality
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        const searchBtn = searchForm.querySelector('.search-btn');
        if (searchBtn) {
            searchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get form values
                const year = searchForm.querySelector('.search-select:nth-child(1)').value;
                const make = searchForm.querySelector('.search-select:nth-child(2)').value;
                const model = searchForm.querySelector('.search-select:nth-child(3)').value;
                const bodyType = searchForm.querySelector('.search-select:nth-child(4)').value;
                
                // Create search parameters
                const params = new URLSearchParams();
                if (year !== 'Any Year') params.append('year', year);
                if (make !== 'Any Make') params.append('make', make);
                if (model !== 'Any Model') params.append('model', model);
                if (bodyType !== 'Any Body Type') params.append('bodyType', bodyType);
                
                // Redirect to inventory page with search parameters
                window.location.href = `inventory.html?${params.toString()}`;
            });
        }
    }

    // Popular makes slider - COMPLETELY FIXED
    const makesSlider = document.getElementById('makesSlider');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (makesSlider && prevBtn && nextBtn) {
        let currentPosition = 0;
        const itemWidth = 220; // 200px width + 20px gap
        const visibleItems = getVisibleItems();
        const totalItems = makesSlider.children.length;
        const maxPosition = Math.max(0, totalItems - visibleItems);
        
        function getVisibleItems() {
            const containerWidth = makesSlider.parentElement.offsetWidth;
            return Math.floor(containerWidth / itemWidth);
        }
        
        function updateSlider() {
            const translateX = -currentPosition * itemWidth;
            makesSlider.style.transform = `translateX(${translateX}px)`;
            
            // Update button states
            prevBtn.disabled = currentPosition === 0;
            nextBtn.disabled = currentPosition >= maxPosition;
        }
        
        function updateVisibleItems() {
            const newVisibleItems = getVisibleItems();
            const newMaxPosition = Math.max(0, totalItems - newVisibleItems);
            
            if (currentPosition > newMaxPosition) {
                currentPosition = newMaxPosition;
            }
            
            updateSlider();
        }
        
        prevBtn.addEventListener('click', function() {
            if (currentPosition > 0) {
                currentPosition--;
                updateSlider();
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (currentPosition < maxPosition) {
                currentPosition++;
                updateSlider();
            }
        });
        
        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(updateVisibleItems, 250);
        });
        
        // Initialize slider
        updateSlider();
        
        // Auto-play functionality (optional)
        let autoPlayInterval;
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                if (currentPosition < maxPosition) {
                    currentPosition++;
                } else {
                    currentPosition = 0;
                }
                updateSlider();
            }, 4000);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        // Start auto-play
        startAutoPlay();
        
        // Pause auto-play on hover
        const sliderContainer = document.querySelector('.makes-slider-container');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', stopAutoPlay);
            sliderContainer.addEventListener('mouseleave', startAutoPlay);
        }
        
        // Touch/swipe support for mobile
        let startX = 0;
        let isDragging = false;
        
        makesSlider.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
            stopAutoPlay();
        });
        
        makesSlider.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            e.preventDefault();
        });
        
        makesSlider.addEventListener('touchend', function(e) {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            
            if (Math.abs(diffX) > 50) { // Minimum swipe distance
                if (diffX > 0 && currentPosition < maxPosition) {
                    // Swipe left - next
                    currentPosition++;
                } else if (diffX < 0 && currentPosition > 0) {
                    // Swipe right - previous
                    currentPosition--;
                }
                updateSlider();
            }
            
            isDragging = false;
            startAutoPlay();
        });
    }

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Header scroll effect - IMPROVED
    const header = document.querySelector('.header');
    let lastScrollTop = 0;
    let scrollTimeout;
    
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        }, 10);
    });

    // Vehicle card interactions - IMPROVED
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    vehicleCards.forEach(card => {
        const applyBtn = card.querySelector('.apply-btn');
        if (applyBtn) {
            applyBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                // Show loading state
                this.textContent = 'LOADING...';
                this.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    this.textContent = 'APPLY ONLINE';
                    this.disabled = false;
                    // Redirect to application page
                    window.location.href = '#apply-online';
                }, 1000);
            });
        }
        
        // Add click to view details
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.apply-btn')) {
                window.location.href = 'vehicle-detail.html';
            }
        });
    });

    // Form validation for search
    const searchSelects = document.querySelectorAll('.search-select');
    searchSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.style.borderColor = this.value ? '#ffff00' : '#333';
        });
    });

    // Lazy loading for images
    const images = document.querySelectorAll('img');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        if (img.dataset.src) {
            imageObserver.observe(img);
        }
    });

    // Error handling for images
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = '/placeholder.svg?height=200&width=300&text=Image+Not+Found';
        });
    });

    // Keyboard navigation support
    document.addEventListener('keydown', function(e) {
        // ESC key closes mobile menu
        if (e.key === 'Escape' && nav && nav.classList.contains('active')) {
            nav.classList.remove('active');
        }
        
        // Arrow keys for slider navigation
        if (e.key === 'ArrowLeft' && prevBtn && !prevBtn.disabled) {
            prevBtn.click();
        } else if (e.key === 'ArrowRight' && nextBtn && !nextBtn.disabled) {
            nextBtn.click();
        }
    });

    // Performance optimization - debounce resize events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Optimized resize handler
    const handleResize = debounce(() => {
        // Recalculate slider dimensions
        if (makesSlider) {
            const event = new Event('resize');
            window.dispatchEvent(event);
        }
    }, 250);

    window.addEventListener('resize', handleResize);

    // Console log for debugging
    console.log('Bucket Buddy Auto - All scripts loaded successfully');
});

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Export functions for use in other scripts
window.BucketBuddyAuto = {
    showNotification,
    // Add other utility functions here
};