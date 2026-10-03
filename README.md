# Orbita Bar - Laravel Project

Сайт бару/пространству «Орбита» (по аналогии с [orbita.bar](https://orbita.bar/)), реализованный на **Laravel**.

## Требования
- PHP >= 8.2 & Composer (для локального запуска) ИЛИ
- Docker & Docker Compose

## Быстрый запуск через Docker (Рекомендуемый способ)

1. Клонируйте репозиторий и перейдите в папку проекта:
```bash
cd orbita
```

2. Запустите проект через Docker Compose:
```bash
docker compose up -d --build
```

3. Откройте сайт в браузере:
[http://localhost:8000](http://localhost:8000)

## Локальный запуск без Docker

1. Установите зависимоти PHP:
```bash
composer install
```

2. Установите зависимости и соберите фронтенд ассеты:
```bash
npm install
npm run build
```

3. Выполните миграции базы данных (SQLite):
```bash
touch database/database.sqlite
php artisan migrate
```

4. Запустите веб-сервер Laravel:
```bash
php artisan serve
```

После этого сайт доступен по адресу [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Тестирование
Для запуска автоматических тестов:
```bash
php artisan test
```
