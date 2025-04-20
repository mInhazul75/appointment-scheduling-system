# Laravel Appointment Scheduling System Appointment API

This is a RESTful API for booking appointments, managing availability, and generating booking links. Built with Laravel and JWT authentication.

---

## 🚀 Features

- JWT-based Authentication
- User Registration & Login
- Host Availability Management
- Appointment Booking with Conflict Detection
- Public Booking Link Generation
- Notification Support (DB-based)
- Modular Service Layer & Custom Response Helpers

---

## 🛠️ Tech Stack

- PHP 8+
- Laravel 10+
- MySQL 
- tymon/jwt-auth
- Laravel Service Classes

---

## 📦 Installation

```bash
# 1. Clone the repository
git clone https://github.com/mInhazul75/appointment-scheduling-system
cd booking-api

# 2. Install dependencies
composer install

# 3. Copy the environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Generate JWT secret
php artisan jwt:secret

# 6. Configure .env
# Update your DB credentials and APP_URL

# 7. Run migrations
php artisan migrate


# 8. Serve the application
php artisan serve
