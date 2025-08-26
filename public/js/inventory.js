// Payment Tooltip Functions - Global Scope
window.showPaymentTooltip = function(event, carId, carPrice) {
    console.log('showPaymentTooltip called with:', { carId, carPrice });
    
    // Предотвращаем всплытие события
    event.stopPropagation();
    event.preventDefault();
    
    const tooltip = document.getElementById('paymentTooltip');
    const paymentAmount = document.getElementById('tooltipPaymentAmount');
    const paymentDetails = document.getElementById('tooltipPaymentDetails');
    
    // Очищаем предыдущие таймеры
    if (window.tooltipHideTimer) {
        clearTimeout(window.tooltipHideTimer);
        window.tooltipHideTimer = null;
    }
    
    console.log('Tooltip element:', tooltip);
    console.log('Payment amount element:', paymentAmount);
    console.log('Payment details element:', paymentDetails);
    
    if (!tooltip) {
        console.error('Tooltip element not found!');
        return false;
    }
    
    // Рассчитываем ежемесячный платеж с процентами
    const downPayment = Math.round(carPrice * 0.1); // 10% от цены как первоначальный взнос
    const loanAmount = carPrice - downPayment;
    const interestRate = 7.29; // Процентная ставка
    const loanTerm = 60; // Срок кредита в месяцах
    const monthlyRate = interestRate / 100 / 12;
    
    let monthlyPayment = 0;
    
    if (monthlyRate > 0) {
        monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm)) / 
                        (Math.pow(1 + monthlyRate, loanTerm) - 1);
    } else {
        monthlyPayment = loanAmount / loanTerm;
    }
    
    console.log('Calculated values:', { monthlyPayment, downPayment, loanAmount });
    
    // Обновляем содержимое тултипа
    if (paymentAmount) {
        paymentAmount.textContent = `$${Math.round(monthlyPayment).toLocaleString()}`;
    }
    if (paymentDetails) {
        paymentDetails.textContent = `Payment calculated based on a 60 month loan with 7.29% interest and $${downPayment.toLocaleString()} down.`;
    }
    
    // Позиционируем тултип рядом с курсором
    const rect = event.target.getBoundingClientRect();
    const tooltipWidth = 320; // Ширина тултипа
    const tooltipHeight = 200; // Примерная высота тултипа
    
    let left = rect.left + rect.width + 10; // 10px отступ от иконки
    let top = rect.top - tooltipHeight / 2 + rect.height / 2;
    
    console.log('Positioning:', { rect, left, top, tooltipWidth, tooltipHeight });
    
    // Проверяем, чтобы тултип не выходил за пределы экрана
    if (left + tooltipWidth > window.innerWidth) {
        left = rect.left - tooltipWidth - 10; // Показываем слева от иконки
    }
    
    if (top < 10) {
        top = 10; // Минимальный отступ сверху
    } else if (top + tooltipHeight > window.innerHeight) {
        top = window.innerHeight - tooltipHeight - 10; // Максимальный отступ снизу
    }
    
    tooltip.style.left = left + 'px';
    tooltip.style.top = top + 'px';
    tooltip.style.setProperty('display', 'block', 'important');
    
    // Добавляем обработчики для тултипа
    tooltip.addEventListener('mouseenter', function() {
        console.log('Mouse entered tooltip - canceling hide timer');
        if (window.tooltipHideTimer) {
            clearTimeout(window.tooltipHideTimer);
            window.tooltipHideTimer = null;
        }
    });
    
    tooltip.addEventListener('mouseleave', function() {
        console.log('Mouse left tooltip - starting hide timer');
        hidePaymentTooltip();
    });
    
    console.log('Tooltip should now be visible at:', { left, top });
    
    return false; // Дополнительно предотвращаем переход
};

window.hidePaymentTooltip = function() {
    console.log('hidePaymentTooltip called');
    const tooltip = document.getElementById('paymentTooltip');
    if (tooltip) {
        // Устанавливаем таймер на скрытие через 100мс
        window.tooltipHideTimer = setTimeout(() => {
            tooltip.style.setProperty('display', 'none', 'important');
            console.log('Tooltip hidden');
            window.tooltipHideTimer = null;
        }, 100);
    } else {
        console.error('Tooltip element not found for hiding');
    }
};

window.getPreQualified = function() {
    // Здесь можно добавить логику для перехода к форме предварительной квалификации
    if (typeof showNotification === 'function') {
        showNotification('Redirecting to pre-qualification form...', 'info');
    }
    
    // Пример перехода на страницу заявки
    setTimeout(() => {
        window.location.href = '/apply-online';
    }, 1000);
};

// Специфичная функциональность страницы инвентаря - ПОЛНОСТЬЮ ИСПРАВЛЕНО
document.addEventListener('DOMContentLoaded', function() {
    // Функциональность фильтров - УЛУЧШЕНО
    const filterGroups = document.querySelectorAll('.filter-group');
    filterGroups.forEach(group => {
        group.addEventListener('click', function() {
            const isActive = this.classList.contains('active');
            
            // Закрываем все остальные фильтры
            filterGroups.forEach(g => {
                g.classList.remove('active');
                const options = g.querySelector('.filter-options');
                if (options) {
                    options.classList.remove('active');
                }
            });
            
            // Переключаем текущий фильтр
            if (!isActive) {
                this.classList.add('active');
                const options = this.querySelector('.filter-options');
                if (options) {
                    options.classList.add('active');
                }
            }
            
            // Обновляем иконку
            const icon = this.querySelector('.material-symbols-outlined');
            if (this.classList.contains('active')) {
                icon.textContent = 'expand_less';
            } else {
                icon.textContent = 'expand_more';
            }
        });
    });

    // Добавляем опции фильтров динамически
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

    // Сброс фильтров - УЛУЧШЕНО
    const resetBtn = document.querySelector('.reset-filters');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            // Сбрасываем все группы фильтров
            filterGroups.forEach(group => {
                group.classList.remove('active');
                const icon = group.querySelector('.material-symbols-outlined');
                icon.textContent = 'expand_more';
                
                const options = group.querySelector('.filter-options');
                if (options) {
                    options.classList.remove('active');
                }
            });
            
            // Сбрасываем все чекбоксы
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Сбрасываем сортировку
            const sortSelect = document.querySelector('.sort-select');
            if (sortSelect) {
                sortSelect.selectedIndex = 0;
            }
            
            // Обновляем кнопку сравнения
            updateCompareButton();
            
            // Показываем уведомление
            showNotification('All filters reset', 'success');
        });
    }

    // Функциональность сравнения - УЛУЧШЕНО
    const compareCheckboxes = document.querySelectorAll('.compare-checkbox input[type="checkbox"]');
    const compareBtn = document.querySelector('.compare-btn');
    
    compareCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCompareButton();
        });
    });
    
    if (compareBtn) {
        compareBtn.addEventListener('click', function() {
            const selectedVehicles = document.querySelectorAll('.compare-checkbox input[type="checkbox"]:checked');
            
            if (selectedVehicles.length < 2) {
                showNotification('Please select at least 2 vehicles for comparison', 'warning');
                return;
            }
            
            if (selectedVehicles.length > 4) {
                showNotification('You can compare maximum 4 vehicles', 'warning');
                return;
            }
            
            showComparisonModal();
        });
    }

    // Функциональность избранного - УЛУЧШЕНО
    const favoriteButtons = document.querySelectorAll('.favorite');
    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isFavorited = this.textContent === 'favorite';
            this.textContent = isFavorited ? 'favorite_border' : 'favorite';
            
            // Анимация
            this.style.transform = 'scale(1.2)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
            
            // Show notification
            const message = isFavorited ? 'Removed from favorites' : 'Added to favorites';
            showNotification(message, 'success');
        });
    });

    // Функциональность карточек автомобилей - УЛУЧШЕНО
    const inventoryCards = document.querySelectorAll('.inventory-card');
    
    inventoryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Не переходим если кликаем на интерактивные элементы
            if (e.target.closest('button') || 
                e.target.closest('input') || 
                e.target.closest('.favorite') ||
                e.target.closest('.compare-checkbox')) {
                return;
            }
            
            // Добавляем анимацию клика
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Переходим на страницу деталей автомобиля
            setTimeout(() => {
                window.location.href = 'vehicle-detail.html';
            }, 200);
        });
        
        // Добавляем эффект наведения для лучшего UX
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });

    // Функциональность поиска из URL параметров
    function parseURLParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const filters = {};
        
        for (const [key, value] of urlParams) {
            filters[key] = value;
        }
        
        return filters;
    }

    // Применяем фильтры из URL
    function applyFiltersFromURL() {
        const filters = parseURLParams();
        
        if (filters.search) {
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.value = filters.search;
                // Здесь можно добавить логику поиска
            }
        }
        
        // Применяем другие фильтры если они есть
        Object.keys(filters).forEach(key => {
            if (key !== 'search') {
                const checkbox = document.querySelector(`input[value="${filters[key]}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            }
        });
    }

    // Функциональность сортировки - УЛУЧШЕНО
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            sortVehicles(sortBy);
        });
    }

    function sortVehicles(sortBy) {
        const vehicleGrid = document.querySelector('.inventory-grid');
        const vehicles = Array.from(vehicleGrid.children);
        
        vehicles.sort((a, b) => {
            let aValue, bValue;
            
            switch(sortBy) {
                case 'price-low':
                    aValue = parsePrice(a);
                    bValue = parsePrice(b);
                    return aValue - bValue;
                case 'price-high':
                    aValue = parsePrice(a);
                    bValue = parsePrice(b);
                    return bValue - aValue;
                case 'year-new':
                    aValue = parseYear(a);
                    bValue = parseYear(b);
                    return bValue - aValue;
                case 'year-old':
                    aValue = parseYear(a);
                    bValue = parseYear(b);
                    return aValue - bValue;
                case 'mileage-low':
                    aValue = parseMileage(a);
                    bValue = parseMileage(b);
                    return aValue - bValue;
                case 'mileage-high':
                    aValue = parseMileage(a);
                    bValue = parseMileage(b);
                    return bValue - aValue;
                default:
                    return 0;
            }
        });
        
        // Перестраиваем DOM
        vehicles.forEach(vehicle => vehicleGrid.appendChild(vehicle));
    }

    function parsePrice(card) {
        const priceElement = card.querySelector('.price-tag');
        return priceElement ? parseInt(priceElement.textContent.replace(/[$,]/g, '')) : 0;
    }

    function parseYear(card) {
        const yearElement = card.querySelector('.vehicle-year-badge');
        return yearElement ? parseInt(yearElement.textContent) : 0;
    }

    function parseMileage(card) {
        const mileageElement = card.querySelector('.spec-item:has(.material-symbols-outlined[textContent="speed"]) span:last-child');
        return mileageElement ? parseInt(mileageElement.textContent.replace(/,/g, '')) : 0;
    }

    // Функциональность пагинации - УЛУЧШЕНО
    function loadInventory() {
        // Здесь будет загрузка данных с сервера
        console.log('Загрузка инвентаря...');
    }

    function loadPage(page) {
        // Здесь будет загрузка конкретной страницы
        console.log(`Загрузка страницы ${page}...`);
    }

    function showNotification(message, type = 'info') {
        // Создаем уведомление
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Добавляем стили
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        
        // Цвета для разных типов уведомлений
        const colors = {
            success: '#4CAF50',
            warning: '#FF9800',
            error: '#F44336',
            info: '#2196F3'
        };
        
        notification.style.backgroundColor = colors[type] || colors.info;
        
        // Добавляем в DOM
        document.body.appendChild(notification);
        
        // Удаляем через 3 секунды
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Инициализация
    applyFiltersFromURL();
    // updateCompareButton(); // Удаляем вызов несуществующей функции
    
    // Show welcome notification
    setTimeout(() => {
        showNotification('Welcome to the inventory!', 'info');
    }, 1000);
});