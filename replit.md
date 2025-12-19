# Laravel Admin Panel Application

## Overview
A comprehensive Laravel-based admin panel for managing a multi-vendor platform (restaurants, drivers, orders, payments, etc.).

## Project Setup
- **Framework**: Laravel 10
- **PHP Version**: 8.2
- **Database**: SQLite (development)
- **Package Manager**: Composer

## Key Features
- Multi-vendor restaurant management
- Order management system
- Driver/Delivery management
- Payment processing (Stripe, PayPal, Razorpay, Paytm)
- AI integration (OpenAI)
- Coupon and discount management
- Dynamic notifications
- User roles and permissions
- Google Cloud Storage integration

## Installation & Running

### Local Development
```bash
composer install
php artisan migrate
php artisan serve --host=0.0.0.0 --port=5000
```

### Dependencies
- PHP 8.2
- Laravel 10.10
- Bootstrap 5.1.3
- Stripe, PayPal, Razorpay SDKs
- Google Cloud client libraries
- OpenAI Laravel SDK

## Recent Changes
- Set up SQLite database with migrations
- Configured Laravel to run on port 5000 with 0.0.0.0 binding
- Generated application caches for optimization
- Created necessary storage directories
- Fixed exception handling configuration

## Deployment
- Application is configured for autoscale deployment
- Uses SQLite database (easily replaceable with PostgreSQL)
- All configuration cached for production
- Routes and Blade templates cached

## Environment Configuration
- `APP_ENV`: local (development)
- `APP_DEBUG`: true (development)
- `DB_CONNECTION`: sqlite
- `QUEUE_CONNECTION`: sync

## Modules
- AI Module (custom)
- Laravel Modules (nwidart)
- Authentication & Authorization (Sanctum, custom permissions)
