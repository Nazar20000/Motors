# API Documentation - D.N B Motors V

## Общая информация

**Base URL:** `https://dnbmotorsv.website/api`

**Content-Type:** `application/json`

**Authentication:** Bearer Token (для защищенных endpoints)

## Endpoints

### 1. Тест API

**GET** `/api/test`

Проверка работоспособности API.

**Response:**
```json
{
    "message": "API is working!"
}
```

### 2. Получение брендов

**GET** `/api/cars/brands`

Получить список всех активных брендов автомобилей.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "BMW",
            "active": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 3. Получение моделей

**GET** `/api/cars/models`

Получить список всех моделей автомобилей.

**Query Parameters:**
- `brand_id` (optional) - ID бренда для фильтрации

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "X5",
            "brand_id": 1,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 4. Получение типов кузова

**GET** `/api/cars/body-types`

Получить список всех типов кузова.

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "SUV",
            "active": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

### 5. Поиск автомобилей

**GET** `/api/cars/search`

Поиск автомобилей с фильтрацией.

**Query Parameters:**
- `brand_id` (optional) - ID бренда
- `model_id` (optional) - ID модели
- `body_type_id` (optional) - ID типа кузова
- `year_from` (optional) - Год от
- `year_to` (optional) - Год до
- `price_min` (optional) - Цена от
- `price_max` (optional) - Цена до
- `page` (optional) - Номер страницы (по умолчанию 1)
- `per_page` (optional) - Количество на страницу (по умолчанию 12)

**Response:**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "brand_id": 1,
                "car_model_id": 1,
                "year": 2020,
                "mileage": 50000,
                "price": "45000.00",
                "color_id": 1,
                "body_type_id": 1,
                "transmission_id": 1,
                "status": "available",
                "vin": "WBA5A7C50FD123456",
                "engine_size": "3.0",
                "horsepower": 300,
                "fuel_type": "gasoline",
                "description": "Отличное состояние",
                "image": "cars/bmw_x5_2020.jpg",
                "published": true,
                "brand": {
                    "id": 1,
                    "name": "BMW"
                },
                "car_model": {
                    "id": 1,
                    "name": "X5"
                },
                "color": {
                    "id": 1,
                    "name": "Черный"
                },
                "body_type": {
                    "id": 1,
                    "name": "SUV"
                },
                "transmission": {
                    "id": 1,
                    "name": "Автоматическая"
                }
            }
        ],
        "first_page_url": "https://dnbmotorsv.website/api/cars/search?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "https://dnbmotorsv.website/api/cars/search?page=1",
        "next_page_url": null,
        "path": "https://dnbmotorsv.website/api/cars/search",
        "per_page": 12,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

### 6. Получение деталей автомобиля

**GET** `/api/cars/{id}`

Получить подробную информацию об автомобиле.

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "brand_id": 1,
        "car_model_id": 1,
        "year": 2020,
        "mileage": 50000,
        "price": "45000.00",
        "color_id": 1,
        "body_type_id": 1,
        "transmission_id": 1,
        "status": "available",
        "vin": "WBA5A7C50FD123456",
        "engine_size": "3.0",
        "horsepower": 300,
        "fuel_type": "gasoline",
        "description": "Отличное состояние",
        "image": "cars/bmw_x5_2020.jpg",
        "published": true,
        "brand": {
            "id": 1,
            "name": "BMW"
        },
        "car_model": {
            "id": 1,
            "name": "X5"
        },
        "color": {
            "id": 1,
            "name": "Черный"
        },
        "body_type": {
            "id": 1,
            "name": "SUV"
        },
        "transmission": {
            "id": 1,
            "name": "Автоматическая"
        },
        "images": [
            {
                "id": 1,
                "car_id": 1,
                "image_path": "cars/bmw_x5_2020_1.jpg",
                "created_at": "2024-01-01T00:00:00.000000Z"
            }
        ]
    }
}
```

## Коды ошибок

| Код | Описание |
|-----|----------|
| 200 | Успешный запрос |
| 400 | Неверный запрос |
| 401 | Не авторизован |
| 404 | Ресурс не найден |
| 422 | Ошибка валидации |
| 429 | Слишком много запросов |
| 500 | Внутренняя ошибка сервера |

## Примеры ошибок

### 422 - Ошибка валидации
```json
{
    "error": "Validation failed",
    "errors": {
        "year_from": [
            "Год не может быть меньше 1990."
        ],
        "price_min": [
            "Цена не может быть отрицательной."
        ]
    }
}
```

### 404 - Ресурс не найден
```json
{
    "error": "Resource not found",
    "message": "The requested resource does not exist"
}
```

### 429 - Слишком много запросов
```json
{
    "error": "Too many requests. Please try again later.",
    "retry_after": 60
}
```

## Rate Limiting

API имеет ограничения на количество запросов:

- **Обычные запросы:** 100 запросов в минуту
- **API запросы:** 60 запросов в минуту
- **Поиск:** 30 запросов в минуту
- **Аутентификация:** 5 попыток в 15 минут

## Заголовки ответа

Все ответы содержат следующие заголовки:

- `X-RateLimit-Limit` - Лимит запросов
- `X-RateLimit-Remaining` - Оставшиеся запросы
- `Content-Type: application/json`

## Поддержка

Для получения поддержки по API обращайтесь:

- Email: support@dnbmotorsv.website
- Телефон: (405) 210-6854 