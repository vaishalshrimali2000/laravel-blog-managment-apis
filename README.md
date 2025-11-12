# 📰 Blog Management API (Laravel 12)

A clean REST API built with **Laravel 12** using **Sanctum Authentication**, **Polymorphic Likes**, and a fully modular structure for managing blogs (CRUD, Likes, Search, Pagination, Filters).

---

## 🚀 Features
- 🔐 **Sanctum Auth** (Login / Register / Token Logout)
- ✍️ **Blog CRUD** (Create, Edit, Delete with Image Upload)
- ❤️ **Like/Unlike Blogs** (Polymorphic Relationship)
- 🔍 **Search & Filter** (By title/description, sort by latest or most liked)
- 📄 **Pagination Support**
- 🧾 **Form Request Validation**
- ⚙️ **Policies for Authorization** (Only owner can update/delete)
- 🧠 **API Resource Formatting**
- 🌱 **Seeder + Factory** for sample data
- 🧰 Built on **Laravel 12.10**

---

## 🧩 Tech Stack
| Component | Technology |
|------------|-------------|
| Framework | Laravel 12 (PHP 8.2) |
| Authentication | Laravel Sanctum |
| Database | MySQL |
| ORM | Eloquent |
| API Docs | Postman Collection |
| Image Storage | Laravel Storage (public disk) |

---

## ⚙️ Installation Guide

```bash
# Clone the repo
git clone https://github.com/vaishalshrimali2000/laravel-blog-managment-apis.git
cd laravel-blog-management-api

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure DB in .env
DB_DATABASE=blog_system
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --seed

# Link storage for images
php artisan storage:link

# Run server
php artisan serve
