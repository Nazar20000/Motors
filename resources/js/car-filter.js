// Car Filter JavaScript
class CarFilter {
    constructor() {
        this.currentPage = 1;
        this.filters = {};
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadBrands();
        this.loadBodyTypes();
        this.applyFiltersFromURL();
    }

    bindEvents() {
        // Filters
        document.querySelectorAll('.filter-select, .filter-input').forEach(element => {
            element.addEventListener('change', () => this.applyFilters());
        });

        // Sorting
        const sortSelect = document.querySelector('.sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', () => this.applyFilters());
        }

        // Reset filters
        const resetBtn = document.querySelector('.reset-filters');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetFilters());
        }

        // Pagination
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('pagination-link')) {
                e.preventDefault();
                this.currentPage = parseInt(e.target.dataset.page);
                this.applyFilters();
            }
        });
    }

    async loadBrands() {
        try {
            const response = await fetch('/api/cars/brands');
            const data = await response.json();
            
            if (data.success) {
                this.populateBrandSelect(data.data);
            }
        } catch (error) {
            console.error('Error loading brands:', error);
        }
    }

    populateBrandSelect(brands) {
        const brandSelect = document.querySelector('select[name="brand_id"]');
        if (brandSelect) {
            brandSelect.innerHTML = '<option value="">All brands</option>';
            brands.forEach(brand => {
                brandSelect.innerHTML += `<option value="${brand.id}">${brand.name}</option>`;
            });
        }
    }

    async loadModels(brandId) {
        try {
            const response = await fetch(`/api/cars/models?brand_id=${brandId}`);
            const data = await response.json();
            
            if (data.success) {
                this.populateModelSelect(data.data);
            }
            return data.data;
        } catch (error) {
            console.error('Error loading models:', error);
            return [];
        }
    }

    async loadBodyTypes() {
        try {
            const response = await fetch('/api/cars/body-types');
            const data = await response.json();
            
            if (data.success) {
                this.populateBodyTypeSelect(data.data);
            }
        } catch (error) {
            console.error('Error loading body types:', error);
        }
    }

    populateBodyTypeSelect(bodyTypes) {
        const bodyTypeSelect = document.querySelector('select[name="body_type_id"]');
        if (bodyTypeSelect) {
            bodyTypeSelect.innerHTML = '<option value="">All body types</option>';
            bodyTypes.forEach(bodyType => {
                bodyTypeSelect.innerHTML += `<option value="${bodyType.id}">${bodyType.name}</option>`;
            });
        }
    }

    populateModelSelect(models) {
        const modelSelect = document.querySelector('select[name="model_id"]');
        if (modelSelect) {
            modelSelect.innerHTML = '<option value="">All models</option>';
            models.forEach(model => {
                modelSelect.innerHTML += `<option value="${model.id}">${model.name}</option>`;
            });
        }
    }

    collectFilters() {
        this.filters = {
            brand_id: document.querySelector('select[name="brand_id"]')?.value,
            model_id: document.querySelector('select[name="model_id"]')?.value,
            body_type_id: document.querySelector('select[name="body_type_id"]')?.value,
            year_min: document.querySelector('input[name="year_min"]')?.value,
            year_max: document.querySelector('input[name="year_max"]')?.value,
            price_min: document.querySelector('input[name="price_min"]')?.value,
            price_max: document.querySelector('input[name="price_max"]')?.value,
            mileage_min: document.querySelector('input[name="mileage_min"]')?.value,
            mileage_max: document.querySelector('input[name="mileage_max"]')?.value,
            sort_by: document.querySelector('.sort-select')?.value,
            page: this.currentPage
        };

        // Remove empty values
        Object.keys(this.filters).forEach(key => {
            if (!this.filters[key]) {
                delete this.filters[key];
            }
        });
    }

    async applyFilters() {
        this.collectFilters();
        
        try {
            const queryString = new URLSearchParams(this.filters).toString();
            const response = await fetch(`/api/cars?${queryString}`);
            const data = await response.json();
            
            if (data.success) {
                this.updateCarGrid(data.data);
                this.updatePagination(data.pagination);
                this.updateResultsInfo(data.pagination);
            }
        } catch (error) {
            console.error('Filtering error:', error);
        }
    }

    updateCarGrid(cars) {
        const grid = document.querySelector('.inventory-grid');
        if (!grid) return;

        grid.innerHTML = '';
        
        cars.forEach(car => {
            const carCard = this.createCarCard(car);
            grid.appendChild(carCard);
        });
    }

    createCarCard(car) {
        const card = document.createElement('div');
        card.className = 'inventory-card';
        card.innerHTML = `
            <div class="card-header">
                <label class="compare-checkbox">
                    <input type="checkbox"> <span>Compare</span>
                </label>
                <span class="material-symbols-outlined favorite">favorite_border</span>
                <button class="apply-online-btn">APPLY ONLINE</button>
            </div>
            <div class="vehicle-image">
                <img src="${car.image ? '/storage/' + car.image : '/img/banner.jpg'}" alt="${car.brand?.name} ${car.car_model?.name}">
            </div>
            <div class="vehicle-details">
                <div class="vehicle-title-row">
                    <h3>${car.brand?.name} ${car.car_model?.name}</h3>
                    <span class="year">${car.year}</span>
                </div>
                <div class="vehicle-info">
                    <span>${car.mileage ? car.mileage + ' km' : 'N/A'}</span>
                    <span>${car.transmission?.name || 'N/A'}</span>
                    <span>${car.body_type?.name || 'N/A'}</span>
                </div>
                <div class="vehicle-price">
                    <span class="price">$${car.price?.toLocaleString()}</span>
                </div>
            </div>
        `;
        
        return card;
    }

    updatePagination(pagination) {
        const paginationContainer = document.querySelector('.pagination');
        if (!paginationContainer) return;

        let paginationHTML = '';
        
        if (pagination.current_page > 1) {
            paginationHTML += `<a href="#" class="pagination-link" data-page="${pagination.current_page - 1}">Previous</a>`;
        }
        
        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === pagination.current_page) {
                paginationHTML += `<span class="current-page">${i}</span>`;
            } else {
                paginationHTML += `<a href="#" class="pagination-link" data-page="${i}">${i}</a>`;
            }
        }
        
        if (pagination.current_page < pagination.last_page) {
            paginationHTML += `<a href="#" class="pagination-link" data-page="${pagination.current_page + 1}">Next</a>`;
        }
        
        paginationContainer.innerHTML = paginationHTML;
    }

    updateResultsInfo(pagination) {
        const resultsInfo = document.querySelector('.results-info');
        if (resultsInfo) {
            resultsInfo.innerHTML = `<span>${pagination.total} vehicles | Page ${pagination.current_page} of ${pagination.last_page}</span>`;
        }
    }

    resetFilters() {
        document.querySelectorAll('.filter-select, .filter-input').forEach(element => {
            element.value = '';
        });
        
        this.currentPage = 1;
        this.applyFilters();
    }

    applyFiltersFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Apply URL filters to form fields
        const year = urlParams.get('year');
        const brandId = urlParams.get('brand_id');
        const modelId = urlParams.get('model_id');
        const bodyTypeId = urlParams.get('body_type_id');
        
        if (year) {
            const yearSelect = document.querySelector('select[name="year"]');
            if (yearSelect) yearSelect.value = year;
        }
        
        if (brandId) {
            const brandSelect = document.querySelector('select[name="brand_id"]');
            if (brandSelect) {
                brandSelect.value = brandId;
                // Load models for selected brand
                this.loadModels(brandId).then(() => {
                    if (modelId) {
                        const modelSelect = document.querySelector('select[name="model_id"]');
                        if (modelSelect) modelSelect.value = modelId;
                    }
                });
            }
        }
        
        if (bodyTypeId) {
            const bodyTypeSelect = document.querySelector('select[name="body_type_id"]');
            if (bodyTypeSelect) bodyTypeSelect.value = bodyTypeId;
        }
        
        // Apply filters
        if (year || brandId || modelId || bodyTypeId) {
            this.applyFilters();
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.inventory-page')) {
        new CarFilter();
    }
}); 