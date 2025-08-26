// Функциональность страницы поиска автомобилей
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('carFinderForm');
    const submitBtn = form.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    // Функциональность подсчета символов
    const textareas = form.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = 1024;
        const countElement = textarea.parentElement.querySelector('.character-count span');
        
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            countElement.textContent = currentLength;
            
            const countContainer = countElement.parentElement;
            countContainer.classList.remove('warning', 'error');
            
            if (currentLength > maxLength * 0.9) {
                countContainer.classList.add('warning');
            }
            if (currentLength > maxLength) {
                countContainer.classList.add('error');
                this.value = this.value.substring(0, maxLength);
                countElement.textContent = maxLength;
            }
        });
    });
    
    // Форматирование номера телефона
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
        }
        this.value = value;
    });
    
    // Валидация поля года
    const yearInput = document.getElementById('year');
    yearInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 4) {
            this.value = this.value.substring(0, 4);
        }
    });
    
    // Форматирование поля пробега
    const mileageInput = document.getElementById('maxMileage');
    mileageInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            value = parseInt(value).toLocaleString();
        }
        this.value = value;
    });
    
    // Валидация в реальном времени
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        const formGroup = field.closest('.form-group');
        const existingError = formGroup.querySelector('.error-message');
        const existingSuccess = formGroup.querySelector('.success-message');
        
        // Удаляем существующие сообщения
        if (existingError) existingError.remove();
        if (existingSuccess) existingSuccess.remove();
        formGroup.classList.remove('error', 'success');
        
        let isValid = true;
        let errorMessage = '';
        
        // Проверяем, не пустое ли поле
        if (field.hasAttribute('required') && !field.value.trim()) {
            isValid = false;
            errorMessage = 'Это поле обязательно для заполнения';
        }
        
        // Валидация email
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                isValid = false;
                errorMessage = 'Пожалуйста, введите корректный email';
            }
        }
        
        // Валидация телефона
        if (field.id === 'phone' && field.value) {
            const phoneRegex = /^\(\d{3}\) \d{3}-\d{4}$/;
            if (!phoneRegex.test(field.value)) {
                isValid = false;
                errorMessage = 'Пожалуйста, введите корректный номер телефона';
            }
        }
        
        // Валидация года
        if (field.id === 'year' && field.value) {
            const year = parseInt(field.value);
            const currentYear = new Date().getFullYear();
            if (year < 1900 || year > currentYear + 1) {
                isValid = false;
                errorMessage = `Год должен быть между 1900 и ${currentYear + 1}`;
            }
        }
        
        // Показываем результат валидации
        if (!isValid) {
            formGroup.classList.add('error');
            const errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            errorElement.textContent = errorMessage;
            formGroup.appendChild(errorElement);
        } else {
            formGroup.classList.add('success');
            const successElement = document.createElement('div');
            successElement.className = 'success-message';
            successElement.textContent = '✓';
            formGroup.appendChild(successElement);
        }
        
        return isValid;
    }
    
    // Обработка отправки формы
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Валидируем все поля
        let isFormValid = true;
        const allFields = form.querySelectorAll('input, select, textarea');
        
        allFields.forEach(field => {
            if (!validateField(field)) {
                isFormValid = false;
            }
        });
        
        if (!isFormValid) {
            showNotification('Please fix the errors in the form', 'error');
            return;
        }
        
        // Показываем состояние загрузки
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-block';
        submitBtn.disabled = true;
        
        // Имитируем отправку формы
        setTimeout(() => {
            // Сохраняем данные формы
            saveFormData();
            
            // Показываем модальное окно успеха
            showSuccessModal();
            
            // Сбрасываем состояние кнопки
            btnText.style.display = 'inline-block';
            btnLoading.style.display = 'none';
            submitBtn.disabled = false;
        }, 2000);
    });
    
    // Функциональность чекбоксов
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const formGroup = this.closest('.form-group');
            if (this.checked) {
                formGroup.classList.add('checked');
            } else {
                formGroup.classList.remove('checked');
            }
        });
    });
    
    // Функциональность селектов
    const selects = form.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.classList.add('selected');
            } else {
                this.classList.remove('selected');
            }
        });
    });
    
    // Функциональность очистки формы
    const resetBtn = form.querySelector('.reset-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Вы уверены, что хотите очистить форму?')) {
                form.reset();
                
                // Удаляем все сообщения об ошибках и успехе
                const errorMessages = form.querySelectorAll('.error-message, .success-message');
                errorMessages.forEach(msg => msg.remove());
                
                // Удаляем классы состояния
                const formGroups = form.querySelectorAll('.form-group');
                formGroups.forEach(group => {
                    group.classList.remove('error', 'success', 'checked', 'selected');
                });
                
                // Сбрасываем счетчики символов
                const countElements = form.querySelectorAll('.character-count span');
                countElements.forEach(count => {
                    count.textContent = '0';
                    count.parentElement.classList.remove('warning', 'error');
                });
                
                showNotification('Form cleared', 'success');
            }
        });
    }
    
    // Функциональность автосохранения
    let autoSaveTimeout;
    const autoSaveFields = form.querySelectorAll('input, select, textarea');
    autoSaveFields.forEach(field => {
        field.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                saveFormData();
                showNotification('Form automatically saved', 'info');
            }, 2000);
        });
    });
    
    // Загружаем сохраненные данные при загрузке страницы
    loadFormData();
    
    // Функция показа модального окна успеха
    function showSuccessModal() {
        const modal = document.createElement('div');
        modal.className = 'success-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h2>✓ Заявка отправлена успешно!</h2>
                </div>
                <div class="modal-body">
                    <p>Спасибо за вашу заявку на поиск автомобиля. Мы свяжемся с вами в ближайшее время.</p>
                    <div class="success-details">
                        <h3>Что дальше?</h3>
                        <ul>
                            <li>Наши специалисты проанализируют ваши требования</li>
                            <li>Мы найдем подходящие варианты в нашем инвентаре</li>
                            <li>Свяжемся с вами для обсуждения деталей</li>
                            <li>Организуем тест-драйв понравившихся автомобилей</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn primary" onclick="window.location.href='inventory.html'">
                        Посмотреть инвентарь
                    </button>
                    <button class="modal-btn secondary" onclick="this.closest('.success-modal').remove()">
                        Закрыть
                    </button>
                </div>
            </div>
        `;
        
        // Добавляем стили модального окна
        const styles = document.createElement('style');
        styles.textContent = `
            .success-modal {
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
                animation: fadeIn 0.3s ease;
            }
            
            .modal-content {
                background: #1a1a1a;
                border-radius: 12px;
                padding: 30px;
                max-width: 500px;
                width: 90%;
                text-align: center;
                animation: slideIn 0.3s ease;
            }
            
            .modal-header h2 {
                color: #4CAF50;
                margin-bottom: 20px;
            }
            
            .modal-body p {
                color: #cccccc;
                margin-bottom: 20px;
            }
            
            .success-details {
                text-align: left;
                margin: 20px 0;
            }
            
            .success-details h3 {
                color: #ffff00;
                margin-bottom: 10px;
            }
            
            .success-details ul {
                color: #cccccc;
                padding-left: 20px;
            }
            
            .success-details li {
                margin-bottom: 5px;
            }
            
            .modal-footer {
                margin-top: 30px;
                display: flex;
                gap: 15px;
                justify-content: center;
            }
            
            .modal-btn {
                padding: 12px 24px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-weight: bold;
                transition: all 0.3s ease;
            }
            
            .modal-btn.primary {
                background: #4CAF50;
                color: white;
            }
            
            .modal-btn.secondary {
                background: #666;
                color: white;
            }
            
            .modal-btn:hover {
                transform: translateY(-2px);
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes slideIn {
                from { transform: translateY(-50px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
        `;
        document.head.appendChild(styles);
        
        document.body.appendChild(modal);
        
        // Закрытие по клику вне модального окна
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
    
    // Функция показа уведомлений
    function showNotification(message, type = 'info') {
        // Удаляем существующие уведомления
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
        
        // Добавляем стили уведомления
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4CAF50' : 
                       type === 'warning' ? '#FF9800' : 
                       type === 'error' ? '#F44336' : '#2196F3'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        `;
        
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
    
    // Функция сохранения данных формы
    function saveFormData() {
        const formData = new FormData(form);
        const data = {};
        
        for (const [key, value] of formData) {
            data[key] = value;
        }
        
        localStorage.setItem('carFinderFormData', JSON.stringify(data));
    }
    
    // Функция загрузки сохраненных данных
    function loadFormData() {
        const savedData = localStorage.getItem('carFinderFormData');
        if (savedData) {
            const data = JSON.parse(savedData);
            
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                    
                    // Обновляем состояние полей
                    if (field.type === 'checkbox') {
                        field.checked = data[key] === 'on';
                        if (field.checked) {
                            field.closest('.form-group').classList.add('checked');
                        }
                    } else if (field.tagName === 'SELECT') {
                        if (field.value) {
                            field.classList.add('selected');
                        }
                    }
                }
            });
            
            // Обновляем счетчики символов
            const textareas = form.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                const countElement = textarea.parentElement.querySelector('.character-count span');
                if (countElement) {
                    countElement.textContent = textarea.value.length;
                }
            });
        }
    }
    
    console.log('Страница поиска автомобилей - все скрипты загружены успешно');
});