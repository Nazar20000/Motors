// JavaScript для галереи изображений автомобиля

let currentImageIndex = 0;
let carImages = [];

// Получение данных об изображениях из HTML
document.addEventListener('DOMContentLoaded', function() {
    const carDataElement = document.getElementById('carData');
    if (carDataElement) {
        const mainImage = carDataElement.dataset.mainImage;
        const imagesData = carDataElement.dataset.images;
        
        if (imagesData) {
            try {
                carImages = JSON.parse(imagesData);
            } catch (e) {
                console.error('Error parsing images data:', e);
                carImages = [];
            }
        }
        
        // Если нет изображений из галереи, но есть основное изображение
        if (carImages.length === 0 && mainImage && mainImage !== '/img/banner.jpg') {
            carImages = [mainImage];
        }
    }
    
    updateImageCounter();
});

// Переход к изображению по индексу
function goToImage(index) {
    if (carImages.length === 0) return;
    
    currentImageIndex = index;
    const mainImage = document.getElementById('mainCarImage');
    const indicators = document.querySelectorAll('.indicator');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    if (mainImage && carImages[index]) {
        mainImage.src = carImages[index];
    }
    
    // Обновляем индикаторы
    indicators.forEach((indicator, i) => {
        indicator.classList.toggle('active', i === index);
    });
    
    // Обновляем миниатюры
    thumbnails.forEach((thumbnail, i) => {
        thumbnail.classList.toggle('active', i === index);
    });
    
    updateImageCounter();
}

// Следующее изображение
function nextImage() {
    if (carImages.length === 0) return;
    
    currentImageIndex = (currentImageIndex + 1) % carImages.length;
    goToImage(currentImageIndex);
}

// Предыдущее изображение
function previousImage() {
    if (carImages.length === 0) return;
    
    currentImageIndex = currentImageIndex === 0 ? carImages.length - 1 : currentImageIndex - 1;
    goToImage(currentImageIndex);
}

// Обновление счетчика изображений
function updateImageCounter() {
    const counter = document.getElementById('imageCounter');
    if (counter && carImages.length > 0) {
        counter.textContent = `${currentImageIndex + 1}/${carImages.length}`;
    }
}

// Переключение избранного
function toggleFavorite() {
    const btn = document.querySelector('.favorite-btn');
    if (btn) {
        btn.classList.toggle('active');
    }
}

// Поделиться автомобилем
function shareVehicle() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        });
    } else {
        // Fallback для браузеров без поддержки Web Share API
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Ссылка скопирована в буфер обмена!');
        });
    }
}

// Переключение калькулятора платежей
function togglePaymentCalculator() {
    const calculator = document.getElementById('paymentCalculator');
    if (calculator) {
        const isVisible = calculator.style.display !== 'none';
        calculator.style.display = isVisible ? 'none' : 'block';
    }
}

// Расчет платежа
function calculatePayment() {
    const carPrice = parseFloat(document.getElementById('carData').dataset.carPrice) || 0;
    const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
    const interestRate = parseFloat(document.getElementById('interestRate').value) || 7.29;
    const loanTerm = parseInt(document.getElementById('loanTerm').value) || 60;
    
    const loanAmount = carPrice - downPayment;
    const monthlyRate = interestRate / 100 / 12;
    
    let monthlyPayment = 0;
    let totalInterest = 0;
    
    if (monthlyRate > 0) {
        monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm)) / 
                        (Math.pow(1 + monthlyRate, loanTerm) - 1);
        totalInterest = (monthlyPayment * loanTerm) - loanAmount;
    } else {
        monthlyPayment = loanAmount / loanTerm;
        totalInterest = 0;
    }
    
    const totalCost = downPayment + (monthlyPayment * loanTerm);
    
    document.getElementById('monthlyPayment').textContent = `$${Math.round(monthlyPayment).toLocaleString()}`;
    document.getElementById('totalInterest').textContent = `$${Math.round(totalInterest).toLocaleString()}`;
    document.getElementById('totalCost').textContent = `$${Math.round(totalCost).toLocaleString()}`;
} 