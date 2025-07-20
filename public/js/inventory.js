// Inventory page specific functionality - COMPLETELY FIXED
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality - IMPROVED
    const filterGroups = document.querySelectorAll('.filter-group');
    filterGroups.forEach(group => {
        group.addEventListener('click', function() {
            const isActive = this.classList.contains('active');
            
            // Close all other filters
            filterGroups.forEach(g => {
                g.classList.remove('active');
                const options = g.querySelector('.filter-options');
                if (options) {
                    options.classList.remove('active');
                }
            });
            
            // Toggle current filter
            if (!isActive) {
                this.classList.add('active');
                const options = this.querySelector('.filter-options');
                if (options) {
                    options.classList.add('active');
                }
            }
            
            // Update icon
            const icon = this.querySelector('.material-symbols-outlined');
            if (this.classList.contains('active')) {
                icon.textContent = 'expand_less';
            } else {
                icon.textContent = 'expand_more';
            }
        });
    });

    // Add filter options dynamically
    const filterData = {
        'Year': ['2024', '2023', '2022', '2021', '2020', '2019', '2018'],
        'Make / Model': ['Tesla', 'BMW', 'Mercedes', 'Audi', 'Porsche', 'Lexus'],
        'Mileage': ['0-10,000', '10,000-25,000', '25,000-50,000', '50,000+'],
        'Price Range': ['Under $20,000', '$20,000-$40,000', '$40,000-$60,000', '$60,000+'],
        'Drivetrain': ['FWD', 'RWD', 'AWD', '4WD'],
        'Exterior Color': ['Black', 'White', 'Silver', 'Red', 'Blue'],
        'Transmission': ['Automatic', 'Manual', 'CVT'],
        'Interior Color': ['Black', 'Beige', 'Gray', 'Brown']
    };

    filterGroups.forEach(group => {
        const title = group.querySelector('h3').textContent.trim();
        const filterKey = title.replace(' expand_more', '').replace(' expand_less', '');
        
        if (filterData[filterKey]) {
            let optionsDiv = group.querySelector('.filter-options');
            if (!optionsDiv) {
                optionsDiv = document.createElement('div');
                optionsDiv.className = 'filter-options';
                group.appendChild(optionsDiv);
            }
            
            filterData[filterKey].forEach(option => {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'filter-option';
                optionDiv.innerHTML = `
                    <input type="checkbox" id="${filterKey}-${option}" value="${option}">
                    <label for="${filterKey}-${option}">${option}</label>
                `;
                optionsDiv.appendChild(optionDiv);
            });
        }
    });

    // Reset filters - IMPROVED
    const resetBtn = document.querySelector('.reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            // Reset all filter groups
            filterGroups.forEach(group => {
                group.classList.remove('active');
                const icon = group.querySelector('.material-symbols-outlined');
                icon.textContent = 'expand_more';
                
                const options = group.querySelector('.filter-options');
                if (options) {
                    options.classList.remove('active');
                }
            });
            
            // Reset all checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Reset sort
            const sortSelect = document.querySelector('.sort-select');
            if (sortSelect) {
                sortSelect.selectedIndex = 0;
            }
            
            // Show notification
            showNotification('Filters reset successfully', 'success');
            
            // Reload inventory
            loadInventory();
        });
    }

    // Sort functionality - IMPROVED
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            showNotification(`Sorting by: ${sortValue}`, 'info');
            
            // Add loading state
            const inventoryGrid = document.querySelector('.inventory-grid');
            inventoryGrid.classList.add('loading');
            
            // Simulate sorting delay
            setTimeout(() => {
                sortVehicles(sortValue);
                inventoryGrid.classList.remove('loading');
            }, 500);
        });
    }

    // Compare functionality - IMPROVED
    const compareCheckboxes = document.querySelectorAll('.compare-checkbox input');
    let selectedVehicles = [];
    const maxCompare = 3;
    
    compareCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const vehicleCard = this.closest('.inventory-card');
            const vehicleTitle = vehicleCard.querySelector('h3').textContent;
            const vehiclePrice = vehicleCard.querySelector('.price-tag').textContent;
            
            if (this.checked) {
                if (selectedVehicles.length < maxCompare) {
                    selectedVehicles.push({
                        title: vehicleTitle,
                        price: vehiclePrice,
                        element: vehicleCard
                    });
                    vehicleCard.style.borderColor = '#ffff00';
                    showNotification(`${vehicleTitle} added to comparison`, 'success');
                } else {
                    this.checked = false;
                    showNotification(`You can compare up to ${maxCompare} vehicles only`, 'warning');
                }
            } else {
                selectedVehicles = selectedVehicles.filter(vehicle => vehicle.title !== vehicleTitle);
                vehicleCard.style.borderColor = 'transparent';
                showNotification(`${vehicleTitle} removed from comparison`, 'info');
            }
            
            updateCompareButton();
        });
    });

    function updateCompareButton() {
        let compareBtn = document.querySelector('.compare-btn');
        if (!compareBtn && selectedVehicles.length > 0) {
            compareBtn = document.createElement('button');
            compareBtn.className = 'compare-btn';
            compareBtn.innerHTML = `Compare (${selectedVehicles.length})`;
            document.querySelector('.inventory-toolbar').appendChild(compareBtn);
            
            compareBtn.addEventListener('click', function() {
                showComparisonModal();
            });
        } else if (compareBtn) {
            if (selectedVehicles.length > 0) {
                compareBtn.innerHTML = `Compare (${selectedVehicles.length})`;
                compareBtn.style.display = 'block';
            } else {
                compareBtn.style.display = 'none';
            }
        }
    }

    function showComparisonModal() {
        const modal = document.createElement('div');
        modal.className = 'comparison-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Vehicle Comparison</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="comparison-grid">
                    ${selectedVehicles.map(vehicle => `
                        <div class="comparison-item">
                            <h3>${vehicle.title}</h3>
                            <p class="price">${vehicle.price}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        modal.querySelector('.close-modal').addEventListener('click', () => {
            modal.remove();
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }

    // Favorite functionality - IMPROVED
    const favoriteIcons = document.querySelectorAll('.favorite');
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    
    // Initialize favorites from localStorage
    favoriteIcons.forEach((icon, index) => {
        const vehicleCard = icon.closest('.inventory-card');
        const vehicleTitle = vehicleCard.querySelector('h3').textContent;
        
        if (favorites.includes(vehicleTitle)) {
            icon.textContent = 'favorite';
            icon.classList.add('active');
        }
    });
    
    favoriteIcons.forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const vehicleCard = this.closest('.inventory-card');
            const vehicleTitle = vehicleCard.querySelector('h3').textContent;
            
            if (this.textContent === 'favorite_border') {
                this.textContent = 'favorite';
                this.classList.add('active');
                favorites.push(vehicleTitle);
                showNotification(`${vehicleTitle} added to favorites`, 'success');
            } else {
                this.textContent = 'favorite_border';
                this.classList.remove('active');
                favorites = favorites.filter(fav => fav !== vehicleTitle);
                showNotification(`${vehicleTitle} removed from favorites`, 'info');
            }
            
            localStorage.setItem('favorites', JSON.stringify(favorites));
        });
    });

    // Pagination - IMPROVED
    const pageNumbers = document.querySelectorAll('.page-number');
    let currentPage = 1;
    const itemsPerPage = 9;
    
    pageNumbers.forEach(pageNum => {
        pageNum.addEventListener('click', function() {
            if (this.classList.contains('active')) return;
            
            // Remove active class from all page numbers
            pageNumbers.forEach(num => num.classList.remove('active'));
            // Add active class to clicked page
            this.classList.add('active');
            
            currentPage = parseInt(this.textContent);
            
            // Show loading
            const inventoryGrid = document.querySelector('.inventory-grid');
            inventoryGrid.classList.add('loading');
            
            // Simulate page load
            setTimeout(() => {
                loadPage(currentPage);
                inventoryGrid.classList.remove('loading');
                
                // Scroll to top of inventory
                document.querySelector('.inventory-content').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 300);
        });
    });

    // Apply online buttons - IMPROVED
    const applyBtns = document.querySelectorAll('.apply-online-btn');
    applyBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const originalText = this.textContent;
            this.textContent = 'LOADING...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.textContent = originalText;
                this.disabled = false;
                showNotification('Redirecting to application form...', 'success');
                
                // Redirect after notification
                setTimeout(() => {
                    window.location.href = '#apply-online';
                }, 1000);
            }, 1000);
        });
    });

    // Vehicle card click to details - IMPROVED
    const inventoryCards = document.querySelectorAll('.inventory-card');
    inventoryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't navigate if clicking on interactive elements
            if (e.target.closest('button') || 
                e.target.closest('input') || 
                e.target.closest('.favorite') ||
                e.target.closest('.compare-checkbox')) {
                return;
            }
            
            // Add click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Navigate to vehicle detail page
            setTimeout(() => {
                window.location.href = 'vehicle-detail.html';
            }, 200);
        });
        
        // Add hover effect for better UX
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });

    // Search functionality from URL parameters
    function parseURLParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const filters = {};
        
        for (const [key, value] of urlParams) {
            filters[key] = value;
        }
        
        return filters;
    }

    function applyFiltersFromURL() {
        const filters = parseURLParams();
        
        Object.keys(filters).forEach(key => {
            const checkbox = document.querySelector(`input[value="${filters[key]}"]`);
            if (checkbox) {
                checkbox.checked = true;
                
                // Open the filter group
                const filterGroup = checkbox.closest('.filter-group');
                if (filterGroup) {
                    filterGroup.classList.add('active');
                    const options = filterGroup.querySelector('.filter-options');
                    if (options) {
                        options.classList.add('active');
                    }
                }
            }
        });
        
        if (Object.keys(filters).length > 0) {
            showNotification('Filters applied from search', 'info');
        }
    }

    // Utility functions
    function sortVehicles(sortBy) {
        const cards = Array.from(document.querySelectorAll('.inventory-card'));
        const grid = document.querySelector('.inventory-grid');
        
        cards.sort((a, b) => {
            switch (sortBy) {
                case 'Price: Low to High':
                    return parsePrice(a) - parsePrice(b);
                case 'Price: High to Low':
                    return parsePrice(b) - parsePrice(a);
                case 'Year: Newest First':
                    return parseYear(b) - parseYear(a);
                case 'Mileage: Low to High':
                    return parseMileage(a) - parseMileage(b);
                default:
                    return 0;
            }
        });
        
        // Clear and re-append sorted cards
        grid.innerHTML = '';
        cards.forEach(card => grid.appendChild(card));
    }

    function parsePrice(card) {
        const priceText = card.querySelector('.price-tag').textContent;
        return parseInt(priceText.replace(/[^0-9]/g, ''));
    }

    function parseYear(card) {
        const titleText = card.querySelector('h3').textContent;
        const yearMatch = titleText.match(/(\d{4})/);
        return yearMatch ? parseInt(yearMatch[1]) : 0;
    }

    function parseMileage(card) {
        const specs = card.querySelectorAll('.spec-item');
        for (const spec of specs) {
            if (spec.querySelector('.material-symbols-outlined').textContent === 'speed') {
                return parseInt(spec.textContent.replace(/[^0-9]/g, ''));
            }
        }
        return 0;
    }

    function loadInventory() {
        const inventoryGrid = document.querySelector('.inventory-grid');
        inventoryGrid.classList.add('loading');
        
        setTimeout(() => {
            inventoryGrid.classList.remove('loading');
            showNotification('Inventory updated', 'success');
        }, 500);
    }

    function loadPage(page) {
        console.log(`Loading page ${page}`);
        // Implement actual page loading logic here
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
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Add CSS for notifications
    const notificationStyles = document.createElement('style');
    notificationStyles.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .comparison-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        
        .modal-content {
            background: #2a2a2a;
            border-radius: 8px;
            padding: 30px;
            max-width: 800px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #444;
        }
        
        .modal-header h2 {
            color: #ffffff;
            margin: 0;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }
        
        .close-modal:hover {
            color: #ffff00;
        }
        
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .comparison-item {
            background: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .comparison-item h3 {
            color: #ffffff;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .comparison-item .price {
            color: #ffff00;
            font-size: 18px;
            font-weight: bold;
        }
        
        .compare-btn {
            background-color: #ffff00;
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 20px;
        }
        
        .compare-btn:hover {
            background-color: #e6e600;
        }
    `;
    document.head.appendChild(notificationStyles);

    // Initialize page
    applyFiltersFromURL();
    
    console.log('Inventory page - All scripts loaded successfully');
});