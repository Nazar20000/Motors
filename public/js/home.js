// JavaScript для главной страницы

class HomePage {
    constructor() {
        this.initializeModelLoading();
        this.initializeSearchForm();
        this.initializeMakesSlider();
        this.initializeVehiclesSlider();
    }

    // Инициализация динамической загрузки моделей
    initializeModelLoading() {
        const brandSelect = document.querySelector('select[name="brand_id"]');
        const modelSelect = document.querySelector('select[name="model_id"]');
        
        if (brandSelect && modelSelect) {
            brandSelect.addEventListener('change', () => {
                this.loadModels(brandSelect.value, modelSelect);
            });
        }
    }

    // Загрузка моделей для выбранного бренда
    loadModels(brandId, modelSelect) {
        // Очищаем список моделей
        modelSelect.innerHTML = '<option value="">Any Model</option>';
        
        if (brandId) {
            // Загружаем модели для выбранного бренда
            fetch(`/api/cars/models?brand_id=${brandId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        data.data.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            modelSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Ошибка загрузки моделей:', error);
                });
        }
    }

    // Инициализация формы поиска
    initializeSearchForm() {
        const searchBtn = document.querySelector('.search-btn');
        
        if (searchBtn) {
            searchBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleSearch();
            });
        }
    }

    // Обработка поиска
    handleSearch() {
        const year = document.querySelector('select[name="year"]').value;
        const brandId = document.querySelector('select[name="brand_id"]').value;
        const modelId = document.querySelector('select[name="model_id"]').value;
        const bodyTypeId = document.querySelector('select[name="body_type_id"]').value;
        
        // Формируем URL для перехода на страницу инвентаря с фильтрами
        let url = '/inventory?';
        const params = [];
        
        if (year) params.push(`year=${year}`);
        if (brandId) params.push(`brand_id=${brandId}`);
        if (modelId) params.push(`model_id=${modelId}`);
        if (bodyTypeId) params.push(`body_type_id=${bodyTypeId}`);
        
        if (params.length > 0) {
            url += params.join('&');
        }
        
        window.location.href = url;
    }

    // Инициализация слайдера популярных марок
    initializeMakesSlider() {
        this.makesContainer = document.querySelector('.makes-container');
        this.leftArrow = document.querySelector('.slider-arrow-left');
        this.rightArrow = document.querySelector('.slider-arrow-right');
        
        if (this.makesContainer && this.leftArrow && this.rightArrow) {
            this.setupSliderArrows();
            this.updateArrowStates();
            this.startAutoSlide(); // Запускаем автоматическую прокрутку
        }
    }

    // Настройка стрелок слайдера
    setupSliderArrows() {
        this.leftArrow.addEventListener('click', () => this.slideMakes('left'));
        this.rightArrow.addEventListener('click', () => this.slideMakes('right'));
        
        // Обновляем состояние стрелок при прокрутке
        this.makesContainer.addEventListener('scroll', () => {
            this.updateArrowStates();
        });
    }

    // Функция прокрутки слайдера
    slideMakes(direction) {
        const container = this.makesContainer;
        const scrollAmount = 300; // Ширина прокрутки
        
        if (direction === 'left') {
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Обновляем состояние стрелок после прокрутки
        setTimeout(() => {
            this.updateArrowStates();
        }, 300);
    }

    // Обновление состояния стрелок
    updateArrowStates() {
        const container = this.makesContainer;
        
        // Проверяем, можно ли прокручивать влево
        if (container.scrollLeft <= 0) {
            this.leftArrow.disabled = true;
        } else {
            this.leftArrow.disabled = false;
        }
        
        // Проверяем, можно ли прокручивать вправо
        if (container.scrollLeft >= container.scrollWidth - container.clientWidth) {
            this.rightArrow.disabled = true;
        } else {
            this.rightArrow.disabled = false;
        }
    }

    // Автоматическая прокрутка слайдера
    startAutoSlide() {
        this.autoSlideInterval = setInterval(() => {
            this.autoSlide();
        }, 4000); // Прокрутка каждые 4 секунды

        // Останавливаем автопрокрутку при наведении мыши
        this.makesContainer.addEventListener('mouseenter', () => {
            this.stopAutoSlide();
        });

        // Возобновляем автопрокрутку при уходе мыши
        this.makesContainer.addEventListener('mouseleave', () => {
            this.startAutoSlide();
        });

        // Останавливаем автопрокрутку при клике на стрелки
        this.leftArrow.addEventListener('click', () => {
            this.stopAutoSlide();
            setTimeout(() => this.startAutoSlide(), 3000); // Возобновляем через 3 секунды
        });

        this.rightArrow.addEventListener('click', () => {
            this.stopAutoSlide();
            setTimeout(() => this.startAutoSlide(), 3000); // Возобновляем через 3 секунды
        });
    }

    // Остановка автоматической прокрутки
    stopAutoSlide() {
        if (this.autoSlideInterval) {
            clearInterval(this.autoSlideInterval);
            this.autoSlideInterval = null;
        }
    }

    // Автоматическая прокрутка
    autoSlide() {
        const container = this.makesContainer;
        const scrollAmount = 100; // Меньший шаг для более плавного движения
        
        // Проверяем, достигли ли конца
        if (container.scrollLeft >= container.scrollWidth - container.clientWidth - 10) {
            // Возвращаемся в начало мгновенно для бесконечности
            container.scrollTo({
                left: 0,
                behavior: 'auto'
            });
        } else {
            // Прокручиваем дальше плавно
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Обновляем состояние стрелок
        setTimeout(() => {
            this.updateArrowStates();
        }, 500);
    }

    // Инициализация слайдера автомобилей
    initializeVehiclesSlider() {
        this.vehiclesContainer = document.querySelector('.vehicles-container');
        this.vehiclesLeftArrow = document.querySelector('.vehicles-slider .slider-arrow-left');
        this.vehiclesRightArrow = document.querySelector('.vehicles-slider .slider-arrow-right');
        
        if (this.vehiclesContainer && this.vehiclesLeftArrow && this.vehiclesRightArrow) {
            this.setupVehiclesSliderArrows();
            this.updateVehiclesArrowStates();
            this.startVehiclesAutoSlide();
        }
    }

    // Настройка стрелок слайдера автомобилей
    setupVehiclesSliderArrows() {
        this.vehiclesLeftArrow.addEventListener('click', () => this.slideVehicles('left'));
        this.vehiclesRightArrow.addEventListener('click', () => this.slideVehicles('right'));
        
        // Обновляем состояние стрелок при прокрутке
        this.vehiclesContainer.addEventListener('scroll', () => {
            this.updateVehiclesArrowStates();
        });
    }

    // Функция прокрутки слайдера автомобилей
    slideVehicles(direction) {
        const container = this.vehiclesContainer;
        const cardWidth = 330; // Ширина карточки + gap (300px + 30px)
        const visibleCards = Math.floor(container.clientWidth / cardWidth);
        const scrollAmount = cardWidth * Math.min(visibleCards, 3); // Прокручиваем максимум 3 карточки за раз
        
        if (direction === 'left') {
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Обновляем состояние стрелок после прокрутки
        setTimeout(() => {
            this.updateVehiclesArrowStates();
        }, 800); // Увеличиваем задержку для плавности
    }

    // Обновление состояния стрелок автомобилей
    updateVehiclesArrowStates() {
        const container = this.vehiclesContainer;
        
        // Проверяем, можно ли прокручивать влево
        if (container.scrollLeft <= 0) {
            this.vehiclesLeftArrow.disabled = true;
        } else {
            this.vehiclesLeftArrow.disabled = false;
        }
        
        // Проверяем, можно ли прокручивать вправо
        if (container.scrollLeft >= container.scrollWidth - container.clientWidth) {
            this.vehiclesRightArrow.disabled = true;
        } else {
            this.vehiclesRightArrow.disabled = false;
        }
    }

    // Автоматическая прокрутка слайдера автомобилей
    startVehiclesAutoSlide() {
        this.vehiclesAutoSlideInterval = setInterval(() => {
            this.autoSlideVehicles();
        }, 8000); // Увеличиваем интервал до 8 секунд для более плавного просмотра

        // Останавливаем автопрокрутку при наведении мыши
        this.vehiclesContainer.addEventListener('mouseenter', () => {
            this.stopVehiclesAutoSlide();
        });

        // Возобновляем автопрокрутку при уходе мыши
        this.vehiclesContainer.addEventListener('mouseleave', () => {
            this.startVehiclesAutoSlide();
        });

        // Останавливаем автопрокрутку при клике на стрелки
        this.vehiclesLeftArrow.addEventListener('click', () => {
            this.stopVehiclesAutoSlide();
            setTimeout(() => this.startVehiclesAutoSlide(), 10000); // Возобновляем через 10 секунд
        });

        this.vehiclesRightArrow.addEventListener('click', () => {
            this.stopVehiclesAutoSlide();
            setTimeout(() => this.startVehiclesAutoSlide(), 10000); // Возобновляем через 10 секунд
        });
    }

    // Остановка автоматической прокрутки автомобилей
    stopVehiclesAutoSlide() {
        if (this.vehiclesAutoSlideInterval) {
            clearInterval(this.vehiclesAutoSlideInterval);
            this.vehiclesAutoSlideInterval = null;
        }
    }

    // Автоматическая прокрутка автомобилей
    autoSlideVehicles() {
        const container = this.vehiclesContainer;
        const cardWidth = 330; // Ширина карточки + gap (300px + 30px)
        const visibleCards = Math.floor(container.clientWidth / cardWidth);
        const scrollAmount = cardWidth * Math.min(visibleCards, 3); // Прокручиваем максимум 3 карточки за раз
        
        // Проверяем, достигли ли конца
        if (container.scrollLeft >= container.scrollWidth - container.clientWidth - 10) {
            // Возвращаемся в начало плавно для бесконечности
            container.scrollTo({
                left: 0,
                behavior: 'smooth'
            });
        } else {
            // Прокручиваем дальше плавно
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Обновляем состояние стрелок
        setTimeout(() => {
            this.updateVehiclesArrowStates();
        }, 800); // Увеличиваем задержку для плавности
    }
}

// Глобальная функция для вызова из HTML (для совместимости)
function slideMakes(direction) {
    if (window.homePage && window.homePage.slideMakes) {
        window.homePage.slideMakes(direction);
    } else {
        // Fallback если класс не инициализирован
        const container = document.querySelector('.makes-container');
        if (container) {
            const scrollAmount = 300;
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    }
}

// Глобальная функция для слайдера автомобилей
function slideVehicles(direction) {
    if (window.homePage && window.homePage.slideVehicles) {
        window.homePage.slideVehicles(direction);
    } else {
        // Fallback если класс не инициализирован
        const container = document.querySelector('.vehicles-container');
        if (container) {
            const cardWidth = 330; // Ширина карточки + gap (300px + 30px)
            const visibleCards = Math.floor(container.clientWidth / cardWidth);
            const scrollAmount = cardWidth * Math.min(visibleCards, 3); // Прокручиваем максимум 3 карточки за раз
            
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    window.homePage = new HomePage();
}); 