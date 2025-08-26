// Ультимативный JavaScript для загрузки изображений - максимально простая логика

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing ultimate image uploads...');
    
    // Находим все input элементы для загрузки изображений
    const fileInputs = document.querySelectorAll('input[type="file"][multiple]');
    console.log('Found file inputs:', fileInputs.length);
    
    fileInputs.forEach(function(input) {
        console.log('Setting up ultimate input:', input.id);
        setupUltimateImageUpload(input);
    });
    
    // Настройка drag and drop
    setupUltimateDragAndDrop();
    
    // Настройка фильтрации моделей
    setupUltimateModelFiltering();
});

function setupUltimateImageUpload(input) {
    const container = input.closest('.file-upload-container');
    if (!container) {
        console.error('Container not found for input:', input.id);
        return;
    }
    
    const preview = container.querySelector('.image-preview-container');
    const status = container.querySelector('.upload-status');
    const error = container.querySelector('.upload-error');
    const statusText = status ? status.querySelector('.status-message span:last-child') : null;
    const errorText = error ? error.querySelector('span:last-child') : null;
    
    let files = [];
    let lastClickTime = 0;
    
    // Обработчик изменения файлов - максимально простой
    input.addEventListener('change', function(e) {
        console.log('File input changed:', e.target.files.length, 'files');
        
        // Проверяем, не слишком ли быстро повторяется событие
        const now = Date.now();
        if (now - lastClickTime < 100) {
            console.log('Click too fast, ignoring...');
            return;
        }
        lastClickTime = now;
        
        handleUltimateFileSelection(e.target.files, files, preview, status, error, statusText, errorText, input);
    });
    
    // Обработчик клика по label - максимально простой
    const label = input.closest('.file-upload-label');
    if (label) {
        label.addEventListener('click', function(e) {
            // Предотвращаем двойной клик
            if (e.target === input) {
                console.log('Direct input click, ignoring label handler');
                return;
            }
            
            console.log('Label clicked, triggering file input');
            e.preventDefault();
            e.stopPropagation();
            
            // Простой клик без задержек
            input.click();
        });
    }
}

function handleUltimateFileSelection(selectedFiles, filesArray, preview, status, error, statusText, errorText, input) {
    console.log('Handling ultimate file selection:', selectedFiles.length, 'files');
    
    const maxSize = 10 * 1024 * 1024; // 10MB (увеличено с 4MB)
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    let validFiles = [];
    let errorMessages = [];
    
    // Скрываем предыдущие сообщения
    hideUltimateMessages(status, error);
    
    // Проверяем каждый файл
    Array.from(selectedFiles).forEach(function(file) {
        console.log('Processing file:', file.name, 'Size:', file.size, 'Type:', file.type);
        
        try {
            // Проверяем размер
            if (file.size > maxSize) {
                errorMessages.push('"' + file.name + '" слишком большой (максимум 10MB)');
                return;
            }
            
            // Проверяем тип
            if (!allowedTypes.includes(file.type)) {
                errorMessages.push('"' + file.name + '" имеет неподдерживаемый формат');
                return;
            }
            
            // Проверяем, что это изображение
            if (!file.type.startsWith('image/')) {
                errorMessages.push('"' + file.name + '" не является изображением');
                return;
            }
            
            validFiles.push(file);
            console.log('File validated:', file.name);
        } catch (e) {
            console.error('Error processing file:', file.name, e);
            errorMessages.push('Ошибка при обработке "' + file.name + '"');
        }
    });
    
    // Показываем ошибки, если есть
    if (errorMessages.length > 0) {
        console.log('Validation errors:', errorMessages);
        showUltimateError(error, errorText, errorMessages.join(', '));
        return;
    }
    
    // Добавляем валидные файлы к существующим
    filesArray.push.apply(filesArray, validFiles);
    console.log('Total valid files:', filesArray.length);
    
    // Обновляем превью
    renderUltimateImagePreviews(preview, filesArray, input);
    
    // Показываем статус
    if (validFiles.length > 0) {
        showUltimateStatus(status, statusText, 'Выбрано ' + validFiles.length + ' файлов');
    }
    
    // Обновляем input
    updateUltimateInputFiles(input, filesArray);
}

function renderUltimateImagePreviews(preview, files, input) {
    console.log('Rendering ultimate image previews for', files.length, 'files');
    
    if (!preview) {
        console.error('Preview container not found');
        return;
    }
    
    preview.innerHTML = '';
    
    if (files.length === 0) {
        preview.innerHTML = '<div class="no-images">Нет выбранных изображений</div>';
        return;
    }
    
    files.forEach(function(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const item = document.createElement('div');
            item.className = 'image-preview-item';
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = file.name;
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '×';
            removeBtn.title = 'Удалить изображение';
            removeBtn.onclick = function() {
                console.log('Removing file:', file.name);
                files.splice(index, 1);
                renderUltimateImagePreviews(preview, files, input);
                updateUltimateInputFiles(input, files);
            };
            
            item.appendChild(img);
            item.appendChild(removeBtn);
            preview.appendChild(item);
        };
        reader.onerror = function(e) {
            console.error('Error reading file:', file.name, e);
        };
        reader.readAsDataURL(file);
    });
}

function updateUltimateInputFiles(input, files) {
    try {
        const dt = new DataTransfer();
        files.forEach(function(file) {
            dt.items.add(file);
        });
        input.files = dt.files;
        console.log('Ultimate input files updated:', input.files.length, 'files');
    } catch (e) {
        console.error('Error updating ultimate input files:', e);
        // Fallback для старых браузеров
        fallbackUltimateFileUpdate(input, files);
    }
}

function fallbackUltimateFileUpdate(input, files) {
    console.log('Using ultimate fallback file update method');
    // Создаем новый input
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.multiple = true;
    newInput.accept = input.accept;
    newInput.name = input.name;
    newInput.id = input.id;
    newInput.className = input.className;
    
    // Заменяем старый input
    input.parentNode.replaceChild(newInput, input);
    
    // Обновляем обработчики
    setupUltimateImageUpload(newInput);
}

function showUltimateStatus(status, statusText, message) {
    console.log('Showing ultimate status:', message);
    if (status && statusText) {
        statusText.textContent = message;
        status.style.display = 'flex';
        setTimeout(function() {
            status.style.display = 'none';
        }, 3000);
    }
}

function showUltimateError(error, errorText, message) {
    console.log('Showing ultimate error:', message);
    if (error && errorText) {
        errorText.textContent = message;
        error.style.display = 'flex';
    }
}

function hideUltimateMessages(status, error) {
    if (status) status.style.display = 'none';
    if (error) error.style.display = 'none';
}

function setupUltimateDragAndDrop() {
    console.log('Setting up ultimate drag and drop...');
    const labels = document.querySelectorAll('.file-upload-label');
    console.log('Found upload labels:', labels.length);
    
    labels.forEach(function(label) {
        label.addEventListener('dragover', function(e) {
            e.preventDefault();
            label.classList.add('drag-over');
        });
        
        label.addEventListener('dragleave', function(e) {
            e.preventDefault();
            label.classList.remove('drag-over');
        });
        
        label.addEventListener('drop', function(e) {
            e.preventDefault();
            label.classList.remove('drag-over');
            
            const input = label.querySelector('input[type="file"]');
            if (input && e.dataTransfer.files.length > 0) {
                console.log('Files dropped:', e.dataTransfer.files.length);
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
}

function setupUltimateModelFiltering() {
    console.log('Setting up ultimate model filtering...');
    const createBrandSelect = document.getElementById('brand-select');
    const createModelSelect = document.getElementById('model-select');
    const editBrandSelect = document.getElementById('brand-select-edit');
    const editModelSelect = document.getElementById('model-select-edit');
    
    if (createBrandSelect && createModelSelect) {
        setupUltimateModelFilteringForSelects(createBrandSelect, createModelSelect);
    }
    
    if (editBrandSelect && editModelSelect) {
        setupUltimateModelFilteringForSelects(editBrandSelect, editModelSelect);
    }
}

function setupUltimateModelFilteringForSelects(brandSelect, modelSelect) {
    brandSelect.addEventListener('change', function() {
        const selectedBrandId = brandSelect.value;
        const modelOptions = modelSelect.querySelectorAll('option');
        
        // Скрываем все опции моделей
        modelOptions.forEach(function(option) {
            if (option.value === '') {
                option.style.display = 'block'; // Показываем "Выберите модель"
            } else {
                const brandId = option.getAttribute('data-brand');
                if (parseInt(brandId) === parseInt(selectedBrandId)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        });
        
        // Сбрасываем выбор модели, если выбран другой бренд
        if (modelSelect.value) {
            const selectedOption = modelSelect.querySelector('option[value="' + modelSelect.value + '"]');
            if (selectedOption && selectedOption.style.display === 'none') {
                modelSelect.value = '';
            }
        }
    });
    
    // Инициализация при загрузке страницы
    if (brandSelect.value) {
        brandSelect.dispatchEvent(new Event('change'));
    }
} 