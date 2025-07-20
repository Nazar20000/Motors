// About Us page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animatedElements = document.querySelectorAll('.about-text, .about-image');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(el);
    });
    
    // Enhanced image hover effects
    const aboutImage = document.querySelector('.about-image');
    if (aboutImage) {
        aboutImage.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        aboutImage.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }
    
    // Social links interaction
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.1)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        // Add click analytics (placeholder)
        link.addEventListener('click', function(e) {
            const platform = this.getAttribute('aria-label');
            console.log(`Social link clicked: ${platform}`);
            // Here you would typically send analytics data
        });
    });
    
    // Contact info click handlers
    const phoneLink = document.querySelector('.contact-info p:has(.material-symbols-outlined[textContent="phone"])');
    const emailLink = document.querySelector('.contact-info p:has(.material-symbols-outlined[textContent="email"])');
    
    if (phoneLink) {
        phoneLink.style.cursor = 'pointer';
        phoneLink.addEventListener('click', function() {
            window.location.href = 'tel:+12792064797';
        });
    }
    
    if (emailLink) {
        emailLink.style.cursor = 'pointer';
        emailLink.addEventListener('click', function() {
            window.location.href = 'mailto:danijela13@gmail.com';
        });
    }
    
    // Parallax effect for about image (subtle)
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.about-image img');
        
        parallaxElements.forEach(element => {
            const speed = 0.1;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
    
    // Text animation on scroll
    const textElements = document.querySelectorAll('.about-description p');
    const textObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }, index * 200);
            }
        });
    }, { threshold: 0.5 });
    
    textElements.forEach(p => {
        p.style.opacity = '0';
        p.style.transform = 'translateX(-20px)';
        p.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        textObserver.observe(p);
    });
    
    // Footer navigation active state
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const footerNavLinks = document.querySelectorAll('.footer-nav a');
    
    footerNavLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.html')) {
            link.style.color = '#ffff00';
            link.style.fontWeight = 'bold';
        }
    });
    
    // Lazy loading for images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Error handling for images
    const allImages = document.querySelectorAll('img');
    allImages.forEach(img => {
        img.addEventListener('error', function() {
            this.src = '/placeholder.svg?height=400&width=600&text=Image+Not+Available';
            this.alt = 'Image not available';
        });
    });
    
    // Keyboard navigation enhancement
    document.addEventListener('keydown', function(e) {
        // ESC key functionality
        if (e.key === 'Escape') {
            // Close any open modals or overlays
            const activeOverlays = document.querySelectorAll('.modal.active, .overlay.active');
            activeOverlays.forEach(overlay => {
                overlay.classList.remove('active');
            });
        }
        
        // Tab navigation enhancement
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });
    
    // Remove keyboard navigation class on mouse use
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });
    
    // Performance optimization - debounce scroll events
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
    
    // Optimized scroll handler
    const handleScroll = debounce(() => {
        requestTick();
    }, 10);
    
    window.addEventListener('scroll', handleScroll);
    
    // Add loading animation
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
        
        // Trigger initial animations
        setTimeout(() => {
            const initialElements = document.querySelectorAll('.about-text, .about-image');
            initialElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        }, 100);
    });
    
    console.log('About Us page - All scripts loaded successfully');
});

// Add CSS for keyboard navigation
const keyboardStyles = document.createElement('style');
keyboardStyles.textContent = `
    .keyboard-navigation *:focus {
        outline: 2px solid #ffff00 !important;
        outline-offset: 2px !important;
    }
    
    .loaded .about-text,
    .loaded .about-image {
        transition: opacity 0.8s ease, transform 0.8s ease;
    }
`;
document.head.appendChild(keyboardStyles);