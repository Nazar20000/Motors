// Car Filter JavaScript
class CarFilter {
    constructor() {
        try {
            console.log('🚀 CarFilter initialized');
            this.init();
            this.saveState();
        } catch (error) {
            console.error('❌ Error in CarFilter constructor:', error);
        }
    }

    init() {
        try {
            this.initFilterTabs();
            this.initFilterSections();
            this.initFilterInputs();
            this.initGalleryNavigation();
            this.loadState();
        } catch (error) {
            console.error('❌ Error in CarFilter init:', error);
        }
    }

    initFilterTabs() {
        const tabs = document.querySelectorAll('.filter-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });
    }

    initFilterSections() {
        const sections = document.querySelectorAll('.filter-section');
        sections.forEach(section => {
            const header = section.querySelector('.filter-header');
            if (header) {
                header.addEventListener('click', () => {
                    section.classList.toggle('active');
                });
            }
        });
    }

    initFilterInputs() {
        // Price range inputs
        const priceInputs = document.querySelectorAll('.price-range input');
        priceInputs.forEach(input => {
            input.addEventListener('input', this.debounce(() => {
                this.applyFilters();
            }, 500));
        });

        // Year range inputs
        const yearInputs = document.querySelectorAll('.year-range input');
        yearInputs.forEach(input => {
            input.addEventListener('input', this.debounce(() => {
                this.applyFilters();
            }, 500));
        });

        // Brand select (for both inventory and home page)
        const brandSelect = document.querySelector('select[name="brand_id"]');
        if (brandSelect) {
            brandSelect.addEventListener('change', () => {
                this.loadModels();
                this.applyFilters();
            });
        }

        // Body type select (for both inventory and home page)
        const bodyTypeSelect = document.querySelector('select[name="body_type_id"]');
        if (bodyTypeSelect) {
            bodyTypeSelect.addEventListener('change', () => {
                this.applyFilters();
            });
        }

        // Model select (for both inventory and home page)
        const modelSelect = document.querySelector('select[name="model_id"]');
        if (modelSelect) {
            modelSelect.addEventListener('change', () => {
                this.applyFilters();
            });
        }

        // Load models if brand is already selected (from URL filters)
        if (brandSelect && brandSelect.value) {
            this.loadModels();
        }
    }

    loadModels() {
        const brandSelect = document.querySelector('select[name="brand_id"]');
        const modelSelect = document.querySelector('select[name="model_id"]');
        
        if (!brandSelect || !modelSelect) return;

        const brandId = brandSelect.value;
        
        if (!brandId) {
            // Clear models if no brand selected
            modelSelect.innerHTML = '<option value="">All Models</option>';
            return;
        }

        // Clear current models
        modelSelect.innerHTML = '<option value="">Loading...</option>';

        // Unregister service workers to avoid interference
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(registrations => {
                for (let registration of registrations) {
                    registration.unregister();
                }
            });
        }

        fetch(`/api/cars/models?brand_id=${brandId}`)
            .then(response => response.json())
            .then(result => {
                if (result.success && result.data) {
                    modelSelect.innerHTML = '<option value="">All Models</option>';
                    result.data.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.id;
                        option.textContent = model.name;
                        modelSelect.appendChild(option);
                    });
                } else {
                    modelSelect.innerHTML = '<option value="">All Models</option>';
                }
            })
            .catch(error => {
                console.error('Error loading models:', error);
                modelSelect.innerHTML = '<option value="">All Models</option>';
            });
    }

    applyFilters() {
        const filters = this.getFilterValues();
        const url = new URL(window.location);
        
        // Clear existing filter params
        url.searchParams.delete('year_from');
        url.searchParams.delete('year_to');
        url.searchParams.delete('brand_id');
        url.searchParams.delete('model_id');
        url.searchParams.delete('body_type_id');
        url.searchParams.delete('price_min');
        url.searchParams.delete('price_max');
        
        // Add new filter params
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                url.searchParams.set(key, filters[key]);
            }
        });
        
        // Update URL without reloading
        window.history.pushState({}, '', url);
        this.saveState();
    }

    getFilterValues() {
        return {
            year_from: document.querySelector('.year-range input:first-child')?.value || '',
            year_to: document.querySelector('.year-range input:last-child')?.value || '',
            brand_id: document.querySelector('select[name="brand_id"]')?.value || '',
            model_id: document.querySelector('select[name="model_id"]')?.value || '',
            body_type_id: document.querySelector('select[name="body_type_id"]')?.value || '',
            price_min: document.querySelector('.price-range input:first-child')?.value || '',
            price_max: document.querySelector('.price-range input:last-child')?.value || ''
        };
    }

    debounce(func, wait) {
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

    saveState() {
        const filters = this.getFilterValues();
        localStorage.setItem('inventoryFilters', JSON.stringify(filters));
    }

    loadState() {
        const saved = localStorage.getItem('inventoryFilters');
        if (saved) {
            const filters = JSON.parse(saved);
            
            // Restore filter values
            const yearInputs = document.querySelectorAll('.year-range input');
            if (yearInputs[0] && filters.year_from) yearInputs[0].value = filters.year_from;
            if (yearInputs[1] && filters.year_to) yearInputs[1].value = filters.year_to;
            
            const priceInputs = document.querySelectorAll('.price-range input');
            if (priceInputs[0] && filters.price_min) priceInputs[0].value = filters.price_min;
            if (priceInputs[1] && filters.price_max) priceInputs[1].value = filters.price_max;
            
            const brandSelect = document.querySelector('select[name="brand_id"]');
            if (brandSelect && filters.brand_id) {
                brandSelect.value = filters.brand_id;
                this.loadModels();
            }
            
            const bodyTypeSelect = document.querySelector('select[name="body_type_id"]');
            if (bodyTypeSelect && filters.body_type_id) {
                bodyTypeSelect.value = filters.body_type_id;
            }
            
            const modelSelect = document.querySelector('select[name="model_id"]');
            if (modelSelect && filters.model_id) {
                // Wait for models to load, then set value
                setTimeout(() => {
                    modelSelect.value = filters.model_id;
                }, 100);
            }
        }
    }

    initGalleryNavigation() {
        const cards = document.querySelectorAll('.vehicle-card');
        cards.forEach(card => {
            const prevBtn = card.querySelector('.gallery-nav.prev');
            const nextBtn = card.querySelector('.gallery-nav.next');
            const indicators = card.querySelectorAll('.indicator');
            let currentImage = 0;

            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    currentImage = Math.max(0, currentImage - 1);
                    this.updateGallery(card, currentImage, indicators);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    currentImage = Math.min(indicators.length - 1, currentImage + 1);
                    this.updateGallery(card, currentImage, indicators);
                });
            }

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', (e) => {
                    e.stopPropagation();
                    currentImage = index;
                    this.updateGallery(card, currentImage, indicators);
                });
            });
        });
    }

    updateGallery(card, currentImage, indicators) {
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentImage);
        });
    }
}

// Global function for card click
function handleCardClick(event, carId) {
    if (event.target.closest('.gallery-nav') || event.target.closest('.indicator')) {
        return;
    }
    window.location.href = `/car/${carId}`;
}

// Global function to clear all filters
function clearAllFilters() {
    // Clear all input values
    const inputs = document.querySelectorAll('.filter-input');
    inputs.forEach(input => input.value = '');
    
    const selects = document.querySelectorAll('.filter-select');
    selects.forEach(select => select.value = '');
    
    // Clear localStorage
    localStorage.removeItem('inventoryFilters');
    
    // Redirect to inventory page without filters
    window.location.href = '/inventory';
}

document.addEventListener('DOMContentLoaded', function() {
    new CarFilter();
}); 