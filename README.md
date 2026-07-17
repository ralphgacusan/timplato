<a id="readme-top"></a>

<!-- PROJECT SHIELDS -->

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![PayMongo](https://img.shields.io/badge/PayMongo-Payment-0052CC?style=for-the-badge)](https://paymongo.com/)
[![Google OAuth](https://img.shields.io/badge/Google-OAuth%202.0-4285F4?style=for-the-badge&logo=google&logoColor=white)](https://developers.google.com/identity)

<br>

<div align="center">

# Timplato

### Systems Integration Approach to E-Commerce for Filipino Kitchenware

A full-stack e-commerce platform developed using Laravel that integrates secure authentication, online payment processing, live customer support, and inventory management to provide Filipino households with a seamless kitchenware shopping experience.

</div>

---

# Table of Contents

- About The Project
- Features
- System Architecture
- Workflow
- Technologies
- Project Structure
- Installation
- Configuration
- Running the Application
- Core Modules
- Integration Architecture
- Database Design
- Design Highlights
- Future Improvements
- Author

---

# About The Project

**Timplato** is a modern e-commerce platform designed to provide Filipino households with affordable, high-quality kitchenware through an intuitive online shopping experience.

The platform enables customers to browse products, securely authenticate using Google OAuth, purchase items through PayMongo payment services, communicate with support using Tawk.to live chat, and track their orders in real time. Administrators can efficiently manage products, inventory, orders, customers, content, and analytics through a comprehensive dashboard.

Built following a modular service-oriented architecture (SOA), Timplato demonstrates systems integration principles by combining multiple internal modules with trusted third-party services into a scalable and maintainable web application.

---

# Features

## Customer Portal

- User registration and authentication
- Google OAuth login
- Product catalog browsing
- Product search and filtering
- Wishlist management
- Shopping cart
- Secure checkout
- Order tracking
- Product reviews and ratings
- Customer support

## Admin Dashboard

- Product management
- Inventory management
- Order management
- User management
- Sales analytics
- Content Management System (CMS)
- Notification management
- Audit trail
- Site configuration

## Third-Party Integrations

- Google OAuth Authentication
- PayMongo Payment Gateway
- Tawk.to Live Chat
- Responsive Bootstrap interface

---

# System Architecture

```text
                 Customer / Admin
                        │
                        ▼
                Laravel Web Application
                        │
        ┌───────────────┼────────────────┐
        ▼               ▼                ▼
     MySQL        Google OAuth      PayMongo
   Database        Authentication    Payments
        │                               │
        └───────────────┬───────────────┘
                        ▼
                  Business Logic
                        │
                        ▼
               Orders • Products
             Inventory • Users
                        │
                        ▼
                 Admin Dashboard
```

---

# Workflow

1. Users register or log in using Google OAuth or traditional authentication.
2. Customers browse products and search the catalog.
3. Products are added to the shopping cart.
4. Checkout is completed using PayMongo.
5. Payment confirmation updates order status.
6. Customers track orders and leave reviews.
7. Administrators manage inventory, products, orders, and reports.

---

# Technologies

## Frontend

- HTML5
- CSS3
- JavaScript
- Bootstrap 5

## Backend

- Laravel 12
- PHP 8.2
- Blade Templates
- Eloquent ORM

## Database

- MySQL

## Authentication

- Laravel Authentication
- Laravel Socialite
- Google OAuth 2.0

## Payment Gateway

- PayMongo API

## Customer Support

- Tawk.to API

## Deployment

- Apache / Nginx
- Composer

---

# Project Structure

```text
timplato/

├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   ├── views/
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
├── tests/
├── artisan
├── composer.json
├── package.json
├── .env
└── README.md
```

---

# Installation

Clone the repository

```bash
git clone https://github.com/yourusername/timplato.git
```

```bash
cd timplato
```

Install PHP dependencies

```bash
composer install
```

Install frontend dependencies

```bash
npm install
```

Create the environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Run database migrations

```bash
php artisan migrate --seed
```

Compile frontend assets

```bash
npm run build
```

---

# Configuration

Configure the following values in `.env`

```env
APP_NAME=Timplato

APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

PAYMONGO_SECRET_KEY=
PAYMONGO_PUBLIC_KEY=

MAIL_MAILER=

TAWKTO_PROPERTY_ID=
TAWKTO_WIDGET_ID=
```

---

# Running the Application

Start Laravel

```bash
php artisan serve
```

Start Vite

```bash
npm run dev
```

Visit

```text
http://localhost:8000
```

---

# Core Modules

## Customer Modules

- User Management
- Product Catalog & Search
- Wishlist
- Shopping Cart
- Checkout
- Order History
- Product Reviews
- Customer Support

## Administrative Modules

- Product Management
- Inventory Management
- Order Management
- User Management
- Sales & Analytics
- Content Management System
- Notification Management
- Audit Trail
- Settings & Configuration

---

# Integration Architecture

## Google OAuth

Provides secure third-party authentication using OAuth 2.0 and Laravel Socialite.

## PayMongo

Processes online payments through cards and GCash while securely handling payment verification using webhooks.

## Tawk.to

Provides real-time customer support through embedded live chat.

## MySQL

Stores all persistent application data including products, orders, users, inventory, payments, and audit logs.

---

# Database Design

The application follows a normalized relational database structure (Third Normal Form) consisting of over twenty interconnected entities.

Core entities include:

- Users
- Products
- Categories
- Orders
- Order Items
- Payments
- Reviews
- Wishlists
- Notifications
- Inventory
- Support Tickets
- Admin Logs
- CMS Pages
- Banners
- Settings

The database is accessed using Laravel Eloquent ORM, ensuring maintainable, object-oriented data operations while preserving referential integrity through foreign key constraints.

---

# Design Highlights

## Service-Oriented Architecture

The system is organized into modular services that separate customer operations, administrative functionality, authentication, payment processing, and content management.

---

## Secure Authentication

Authentication combines Laravel's built-in authentication with Google OAuth to provide secure and convenient account access.

---

## Payment Integration

PayMongo enables PCI-compliant payment processing while keeping sensitive financial information outside the application's infrastructure.

---

## Modular Administration

A centralized dashboard allows administrators to manage inventory, products, users, orders, reports, and website content independently.

---

## Real-Time Customer Experience

Customers receive live updates through notifications, order tracking, and integrated live chat support.

---

## Scalability

The modular architecture allows future integration with mobile applications, additional payment gateways, loyalty programs, and marketplace features.

---

# Future Improvements

- Mobile application
- AI-powered product recommendations
- Loyalty and rewards program
- Supplier management portal
- Multi-vendor marketplace
- Real-time inventory synchronization
- Docker deployment
- Kubernetes orchestration
- Recommendation engine
- Business intelligence dashboard

---

# Author

**Ralph Jayrell Gacusan**

Backend Developer • Full Stack Developer • Data & AI Enthusiast

GitHub

https://github.com/ralphgacusan

---

<p align="right">(<a href="#readme-top">back to top</a>)</p>