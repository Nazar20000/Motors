// Vehicle detail page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const prevBtn = document.querySelector('.image-control.prev');
    const nextBtn = document.querySelector('.image-control.next');
    const thumbnailNav = document.querySelector('.thumbnail-nav');
    
    let currentImageIndex = 0;
    const images = [
        './resurs/porshe_car.jpeg',
        './resurs/martin.jpeg',
        './resurs/porsh.jpeg',
        './resurs/martin.jpeg',
        './resurs/martin.jpeg'
    ];

    // Thumbnail click functionality
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            currentImageIndex = index;
            updateMainImage();
            updateActiveThumbnail();
        });
    });

    // Previous/Next image controls
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
            updateMainImage();
            updateActiveThumbnail();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
            updateMainImage();
            updateActiveThumbnail();
        });
    }

    // Thumbnail navigation
    if (thumbnailNav) {
        thumbnailNav.addEventListener('click', function() {
            // Scroll thumbnail gallery (placeholder functionality)
            console.log('Scrolling thumbnail gallery');
        });
    }

    function updateMainImage() {
        if (mainImage) {
            mainImage.src = images[currentImageIndex];
        }
    }

    function updateActiveThumbnail() {
        thumbnails.forEach((thumbnail, index) => {
            if (index === currentImageIndex) {
                thumbnail.classList.add('active');
            } else {
                thumbnail.classList.remove('active');
            }
        });
    }

    // Action button functionality
    const scheduleTestDriveBtn = document.querySelector('.action-btn.primary');
    const applyOnlineBtn = document.querySelectorAll('.action-btn.primary')[1];
    const requestQuoteBtn = document.querySelector('.action-btn.secondary');

    if (scheduleTestDriveBtn) {
        scheduleTestDriveBtn.addEventListener('click', function() {
            alert('Redirecting to test drive scheduling...');
        });
    }

    if (applyOnlineBtn) {
        applyOnlineBtn.addEventListener('click', function() {
            alert('Redirecting to online application...');
        });
    }

    if (requestQuoteBtn) {
        requestQuoteBtn.addEventListener('click', function() {
            alert('Opening quote request form...');
        });
    }

    // Keyboard navigation for image gallery
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
            updateMainImage();
            updateActiveThumbnail();
        } else if (e.key === 'ArrowRight') {
            currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
            updateMainImage();
            updateActiveThumbnail();
        }
    });

    // Image zoom functionality (optional enhancement)
    if (mainImage) {
        mainImage.addEventListener('click', function() {
            // Toggle zoom or open lightbox
            this.classList.toggle('zoomed');
        });
    }
});