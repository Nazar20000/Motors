// Main JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
        });
    }

    // Search form functionality
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        const searchBtn = searchForm.querySelector('.search-btn');
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Redirect to inventory page with search parameters
            window.location.href = 'inventory.html';
        });
    }

    // Popular makes slider
    const makesSlider = document.querySelector('.makes-slider');
    if (makesSlider) {
        const prevBtn = makesSlider.querySelector('.prev');
        const nextBtn = makesSlider.querySelector('.next');
        const makesGrid = makesSlider.querySelector('.makes-grid');
        
        let currentSlide = 0;
        const totalSlides = 3; // Assuming 3 sets of makes
        
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function() {
                currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1;
                updateSlider();
            });
            
            nextBtn.addEventListener('click', function() {
                currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
                updateSlider();
            });
        }
        
        function updateSlider() {
            if (makesGrid) {
                makesGrid.style.transform = `translateX(-${currentSlide * 100}%)`;
            }
        }
    }

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Header scroll effect
    const header = document.querySelector('.header');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });

    // Vehicle card interactions
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    vehicleCards.forEach(card => {
        const applyBtn = card.querySelector('.apply-btn');
        if (applyBtn) {
            applyBtn.addEventListener('click', function() {
                // Redirect to application page or show modal
                alert('Redirecting to application form...');
            });
        }
    });
});