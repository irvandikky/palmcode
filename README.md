# Palmcode - Headless CMS with TALL Stack

A headless CMS built using Laravel, Livewire, Alpine.js, and Tailwind CSS.  
It allows content management via a modern UI and exposes content through a public REST API.

## 🚀 Tech Stack

-   Laravel (v12)
-   Laravel Sanctum
-   Livewire (v3)
-   Alpine.js
-   Tailwind CSS
-   TALL Stack

## 📦 Features

-   Admin authentication (Sanctum, Breeze + Livewire)
-   CRUD for Posts, Pages, Categories
-   Media Manager with drag-and-drop upload
-   REST API: Posts, Pages, Categories
-   Realtime UI via Livewire
-   Responsive & dark-mode friendly UI

## 📁 Project Structure

-   `app/Models`: Eloquent models (Post, Page, Category, User)
-   `app/Livewire`: Livewire components
-   `app/Http/Resources`:  API Resources for transforming models into JSON responses
-   `app/Http/Controllers/API`: Public API controllers
-   `routes/web.php`: Web routes for the admin panel
-   `routes/api.php`: JSON API routes
-   `resources/views/livewire`: Blade views

## 🔧 Installation

```bash
git clone https://github.com/irvandikky/palmcode-headless-cms.git
cd palmcode-headless-cms
cp .env.example .env
composer install
npm install && npm run build
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## 📚 API Documentation

This project uses [Scribe](https://scribe.knuckles.wtf) for generating API documentation.

Access full API docs at:

👉 [https://domain.com/api/docs](https://domain.com/api/docs)

## Default Admin
``` bash
admin@admin.com
admin
```
