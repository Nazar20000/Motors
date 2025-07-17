// Inventory page specific functionality
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterGroups = document.querySelectorAll('.filter-group');
    filterGroups.forEach(group => {
        group.addEventListener('click', function() {
            // Toggle filter dropdown (placeholder functionality)
            const icon = this.querySelector('.material-symbols-outlined');
            if (icon.textContent === 'expand_more') {
                icon.textContent = 'expand_less';
            } else {
                icon.textContent = 'expand_more';
            }
        });
    });

    // Reset filters
    const resetBtn = document.querySelector('.reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            // Reset all filters
            const filterGroups = document.querySelectorAll('.filter-group .material-symbols-outlined');
            filterGroups.forEach(icon => {
                icon.textContent = 'expand_more';
            });
            
            // Reset checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    }

    // Sort functionality
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            // Sort vehicles based on selection
            console.log('Sorting by:', this.value);
        });
    }

    // Compare functionality
    const compareCheckboxes = document.querySelectorAll('.compare-checkbox input');
    let selectedVehicles = [];
    
    compareCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const vehicleCard = this.closest('.inventory-card');
            const vehicleTitle = vehicleCard.querySelector('h3').textContent;
            
            if (this.checked) {
                if (selectedVehicles.length < 3) {
                    selectedVehicles.push(vehicleTitle);
                } else {
                    this.checked = false;
                    alert('You can compare up to 3 vehicles only.');
                }
            } else {
                selectedVehicles = selectedVehicles.filter(title => title !== vehicleTitle);
            }
            
            console.log('Selected vehicles for comparison:', selectedVehicles);
        });
    });

    // Favorite functionality
    const favoriteIcons = document.querySelectorAll('.favorite');
    favoriteIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            if (this.textContent === 'favorite_border') {
                this.textContent = 'favorite';
                this.style.color = '#ffff00';
            } else {
                this.textContent = 'favorite_border';
                this.style.color = '#cccccc';
            }
        });
    });

    // Pagination
    const pageNumbers = document.querySelectorAll('.page-number');
    pageNumbers.forEach(pageNum => {
        pageNum.addEventListener('click', function() {
            // Remove active class from all page numbers
            pageNumbers.forEach(num => num.classList.remove('active'));
            // Add active class to clicked page
            this.classList.add('active');
            
            // Load new page content (placeholder)
            console.log('Loading page:', this.textContent);
        });
    });

    // Apply online buttons
    const applyBtns = document.querySelectorAll('.apply-online-btn');
    applyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Redirecting to online application...');
        });
    });

    // Vehicle card click to details
    const inventoryCards = document.querySelectorAll('.inventory-card');
    inventoryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't navigate if clicking on buttons or checkboxes
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT' || e.target.closest('button')) {
                return;
            }
            
            // Navigate to vehicle detail page
            window.location.href = 'vehicle-detail.html';
        });
    });
});