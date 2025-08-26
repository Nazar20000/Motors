// Функциональность страницы "О нас"
document.addEventListener('DOMContentLoaded', function() {
    // Плавная анимация появления при прокрутке
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
    
    // Наблюдаем за элементами для анимации
    const animatedElements = document.querySelectorAll('.about-text, .about-image');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(el);
    });
    
    // Улучшенные эффекты наведения для изображения
    const aboutImage = document.querySelector('.about-image');
    if (aboutImage) {
        aboutImage.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        aboutImage.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }
    
    // Взаимодействие с социальными ссылками
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.1)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        // Добавляем аналитику кликов (заглушка)
        link.addEventListener('click', function(e) {
            const platform = this.getAttribute('aria-label');
            console.log(`Клик по социальной ссылке: ${platform}`);
            // Здесь обычно отправляются данные аналитики
        });
    });
    
    // Обработчики кликов для контактной информации
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
    
    // Эффект параллакса для изображения "О нас" (тонкий)
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
    
    // Функциональность формы обратной связи
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Получаем данные формы
            const formData = new FormData(this);
            const name = formData.get('name');
            const email = formData.get('email');
            const message = formData.get('message');
            
            // Простая валидация
            if (!name || !email || !message) {
                showNotification('Please fill in all fields', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email', 'error');
                return;
            }
            
            // Показываем состояние загрузки
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Отправка...';
            submitBtn.disabled = true;
            
            // Имитируем отправку формы
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                
                // Очищаем форму
                this.reset();
                
                // Show success notification
                showNotification('Message sent successfully!', 'success');
            }, 2000);
        });
    }
    
    // Функциональность карты
    const mapContainer = document.querySelector('.map-container');
    if (mapContainer) {
        // Инициализация интерактивной карты (заглушка)
        mapContainer.addEventListener('click', function() {
            showNotification('Opening map in new window...', 'info');
            // Здесь можно открыть Google Maps или другую карту
        });
    }
    
    // Функциональность статистики
    const statsElements = document.querySelectorAll('.stat-number');
    statsElements.forEach(stat => {
        const targetNumber = parseInt(stat.getAttribute('data-target'));
        const duration = 2000; // 2 секунды
        const increment = targetNumber / (duration / 16); // 60 FPS
        let currentNumber = 0;
        
        const updateCounter = () => {
            currentNumber += increment;
            if (currentNumber < targetNumber) {
                stat.textContent = Math.floor(currentNumber).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                stat.textContent = targetNumber.toLocaleString();
            }
        };
        
        // Запускаем анимацию счетчика при появлении в поле зрения
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    statObserver.unobserve(entry.target);
                }
            });
        });
        
        statObserver.observe(stat);
    });
    
    // Функциональность команды
    const teamMembers = document.querySelectorAll('.team-member');
    teamMembers.forEach(member => {
        member.addEventListener('mouseenter', function() {
            const info = this.querySelector('.member-info');
            if (info) {
                info.style.opacity = '1';
            }
        });
        
        member.addEventListener('mouseleave', function() {
            const info = this.querySelector('.member-info');
            if (info) {
                info.style.opacity = '0';
            }
        });
    });
    
    // Функциональность истории компании
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        // Добавляем задержку для анимации появления
        item.style.animationDelay = `${index * 0.2}s`;
        
        item.addEventListener('click', function() {
            // Показываем дополнительную информацию
            const details = this.querySelector('.timeline-details');
            if (details) {
                details.style.display = details.style.display === 'block' ? 'none' : 'block';
            }
        });
    });
    
    // Утилитарные функции
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
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
    
    // Функция debounce для оптимизации производительности
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
    
    // Оптимизируем обработчик прокрутки
    const debouncedRequestTick = debounce(requestTick, 16);
    window.removeEventListener('scroll', requestTick);
    window.addEventListener('scroll', debouncedRequestTick);
    
    console.log('Страница "О нас" - все скрипты загружены успешно');
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