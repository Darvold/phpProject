📚 Laravel Vue CRM System
https://img.shields.io/badge/PHP-8892BF?style=for-the-badge&logo=php&logoColor=white
https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
https://img.shields.io/badge/Vue.js-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white
https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white

Учебный full-stack проект системы управления пользователями и книгами, построенный на стеке Laravel + Vue.js с реализацией REST API и динамического интерфейса.

🎯 Цель проекта
Создание полнофункциональной CRM-системы для управления пользователями и книгами с современным интерфейсом, реализованной с использованием паттерна MVC и SPA-подхода.

🚀 Технологический стек
Backend
Laravel 10+ - PHP фреймворк

Eloquent ORM - для работы с базой данных

Middleware - кастомные посредники для контроля доступа

REST API - JSON API для клиентской части

Session-based Authentication - аутентификация через сессии

Frontend
Vue.js 3 - прогрессивный JavaScript фреймворк

Vue Router - для маршрутизации на клиенте

Axios - для HTTP-запросов к API

Tailwind CSS - для стилизации (опционально)

База данных
MySQL - реляционная СУБД

Пагинация - нативная пагинация Laravel

Soft Deletes - мягкое удаление записей

📁 Структура проекта
text
laravel-vue-crm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── RegistAndLoginUserController.php  # Авторизация/регистрация
│   │   │   ├── HomeUserController.php            # Профиль пользователя
│   │   │   └── UserController.php                # Управление пользователями
│   │   ├── Middleware/
│   │   │   ├── CheckUserAccess.php              # Проверка доступа
│   │   │   └── AjaxOnly.php                     # AJAX middleware
│   │   └── Models/
│   │       └── Users.php                        # Модель пользователей
├── resources/
│   └── views/
│       ├── layouts/
│       └── pages/                               # Blade шаблоны
├── routes/
│   └── web.php                                  # Маршрутизация
└── public/
    └── js/
        └── app.js                               # Vue.js приложение
🔐 Система маршрутизации
Публичные маршруты
php
// Очистка кэша (для разработки)
Route::get('/cc', function () { /* ... */ });

// Восстановление пользователей
Route::get('/reset', function () { /* ... */ });

// Авторизация
Route::get('/', [LoginController::class, 'loginUser'])->name('login.index');
Route::post('/', [LoginController::class, 'loginUserPost'])->name('login.store');

// Регистрация
Route::get('/registr', [RegistController::class, 'registrationUser'])->name('regist.index');
Route::post('/registr', [RegistController::class, 'registrationUserPost'])->name('regist.store');
Защищенные маршруты (требуют аутентификации)
php
Route::middleware([CheckUserAccess::class])->group(function () {
    // Профиль пользователя
    Route::get('/home', [HomeController::class, 'homeUser'])->name('home.index');
    Route::put('/home', [HomeController::class, 'updateProfile'])->name('home.put');
    
    // CRUD операции
    Route::get('/CRUD/users', [HomeController::class, 'crudUsers'])->name('crudUsers.index');
    Route::get('/CRUD/books', [HomeController::class, 'crudBooks'])->name('crudBooks.index');
    
    // Выход из системы
    Route::post('/logout', [UserController::class, 'logout'])->name('logoutUser.store');
});
API маршруты (AJAX только)
php
Route::middleware([AjaxOnly::class])->group(function () {
    // Получение пользователей с пагинацией
    Route::get('/api/CRUD/users', function (Request $request) {
        // Пагинация с отслеживанием активности
        $users = Users::paginate($perPage);
        return response()->json($users);
    });
    
    // CRUD операции
    Route::post('/api/CRUD/users/update', 'updateUserData')->name('userUpdate.api.post');
    Route::post('/api/CRUD/users/create', 'createUserData')->name('userCreate.api.post');
    Route::post('/api/CRUD/users/delete', 'deleteUserData')->name('userDelete.api.post');
});
✨ Ключевые особенности
1. Интерфейс управления пользователями
Динамическая таблица пользователей с Vue.js

Поиск и фильтрация

Пагинация (6 пользователей на страницу)

Отслеживание активности пользователей в реальном времени

Статусы "Активен"/"Не активен"

2. Система аутентификации
Регистрация новых пользователей

Авторизация с сохранением сессии

Middleware для контроля доступа

Выход из системы с очисткой сессии

3. CRUD операции
Создание новых пользователей

Чтение списка пользователей с пагинацией

Обновление данных пользователей

Удаление (мягкое удаление с возможностью восстановления)

4. Динамический интерфейс
Анимированные переходы

Градиентные элементы в стиле Vue

Интерактивная панель управления

Адаптивный дизайн

5. Безопасность
Middleware для проверки AJAX-запросов

Защита от CSRF

Валидация данных на сервере

Контроль доступа к маршрутам

🛠️ Установка и запуск
Требования
PHP 8.1+

Composer

Node.js 16+

MySQL 5.7+

Установка
bash
# Клонирование репозитория
git clone https://github.com/ваш-username/laravel-vue-crm.git
cd laravel-vue-crm

# Установка зависимостей PHP
composer install

# Установка зависимостей JavaScript
npm install

# Создание файла окружения
cp .env.example .env

# Генерация ключа приложения
php artisan key:generate

# Настройка базы данных в .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue_crm
DB_USERNAME=root
DB_PASSWORD=

# Миграция базы данных
php artisan migrate

# Сборка фронтенда
npm run build

# Запуск сервера разработки
php artisan serve
Утилиты разработчика
bash
# Очистка кэша (доступно по /cc)
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# Восстановление удаленных пользователей (доступно по /reset)
php artisan tinker
>>> Users::onlyTrashed()->restore();
