<a id="readme-top"></a>

<!-- PROJECT SHIELDS -->

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <h1 align="center">Timplato</h1>
  <p align="center">
    A Filipino kitchenware e-commerce platform for product discovery, online shopping, secure payments, order management, and customer support.
    <br />
    <br />
    <a href="#about-the-project">About</a>
    ·
    <a href="#getting-started">Getting Started</a>
    ·
    <a href="#usage">Usage</a>
  </p>
</div>

---

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#key-features">Key Features</a></li>
        <li><a href="#system-workflow">System Workflow</a></li>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#environment-variables">Environment Variables</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#system-architecture">System Architecture</a></li>
    <li><a href="#database-structure">Database Structure</a></li>
    <li><a href="#integrations">Integrations</a></li>
    <li><a href="#authentication--security">Authentication & Security</a></li>
    <li><a href="#api--integration-documentation">API & Integration Documentation</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

---

## About The Project

Timplato is a full-stack e-commerce platform designed for Filipino households looking for affordable, practical, and quality kitchenware.

The platform provides a centralized online marketplace for cookware, utensils, food preparation tools, tableware, and other kitchen essentials. It combines product discovery, shopping cart management, checkout, online payments, order tracking, reviews, and customer support into a single system.

Timplato was developed as a systems integration and architecture project, focusing on modularity, system integration, secure transactions, maintainability, and future scalability.

The name Timplato combines the Filipino words _timpla_ (to mix or season) and _plato_ (plate), reflecting the platform's focus on cooking, food preparation, and Filipino households.

### Key Features

- Customer registration and authentication
- Google OAuth 2.0 authentication
- Product catalog and product search
- Product categories and filtering
- Shopping cart management
- Checkout and order processing
- Online payments through PayMongo
- Order history and tracking
- Product reviews and ratings
- Customer support through Tawk.to
- Interactive business location through Google Maps
- Admin product management
- Admin order management
- Inventory management
- User and role management
- Sales and analytics reports
- Content management
- Notification management
- System settings and configuration
- Audit trail for administrative activities
- Responsive web interface

### System Workflow

```text
                         Timplato E-Commerce Platform
                                      │
                 ┌────────────────────┴────────────────────┐
                 │                                         │
              Customer                                   Admin
                 │                                         │
       ┌─────────┼─────────┐                    ┌──────────┼──────────┐
       │         │         │                    │          │          │
    Browse     Cart     Account              Products    Orders    Inventory
       │         │         │                    │          │          │
       └─────────┼─────────┘                    └──────────┼──────────┘
                 │                                         │
                 ▼                                         ▼
           Checkout & Payment                        Admin Management
                 │                                         │
                 ▼                                         │
            PayMongo API                                   │
                 │                                         │
                 └────────────────┬────────────────────────┘
                                  │
                                  ▼
                           Laravel Application
                                  │
                    ┌─────────────┼─────────────┐
                    │             │             │
                    ▼             ▼             ▼
                 MySQL      External APIs    Authentication
                               │
                 ┌─────────────┼─────────────┐
                 │             │             │
                 ▼             ▼             ▼
           Google OAuth     PayMongo       Tawk.to
                 │                           │
                 └─────────────┬─────────────┘
                               │
                               ▼
                          Google Maps
```

---

### Built With

The project uses the following technologies and frameworks:

**Backend**

- PHP 8.2+
- Laravel
- Laravel Eloquent ORM
- Laravel Blade
- Laravel Authentication
- Laravel Socialite

**Frontend**

- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- AJAX / Fetch API

**Database**

- MySQL
- SQL
- Eloquent ORM
- Relational database design

**Authentication & Security**

- Laravel Authentication
- Google OAuth 2.0
- Laravel Socialite
- Password hashing
- Role-based access control
- CSRF protection
- HTTPS

**External Integrations**

- Google OAuth 2.0
- PayMongo API
- Tawk.to
- Google Maps API

**Development & Deployment**

- Git
- GitHub
- Docker
- Render
- Railway
- Hostinger

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Getting Started

Follow the steps below to set up the Timplato application locally.

### Prerequisites

Make sure the following are installed before running the application.

- PHP 8.2+
- Composer
- MySQL
- Node.js and npm
- Git
- Docker (optional)

You can verify the installed versions using:

```sh
php --version
composer --version
mysql --version
node --version
npm --version
git --version
```

---

### Installation

**1. Clone the Repository**

```sh
git clone https://github.com/ralphgacusan/timplato.git
cd timplato
```

**2. Install PHP Dependencies**

```sh
composer install
```

**3. Install Frontend Dependencies**

```sh
npm install
```

**4. Configure Environment Variables**

Create a `.env` file in the project root.

You can copy the example environment file if available:

```sh
cp .env.example .env
```

For Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```sh
php artisan key:generate
```

**5. Configure the Database**

Create a MySQL database for the project.

Example:

```text
Database Name: timplato
```

Update the database configuration in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=timplato
DB_USERNAME=root
DB_PASSWORD=
```

**6. Run Database Migrations**

```sh
php artisan migrate
```

If the project includes database seeders:

```sh
php artisan db:seed
```

Or:

```sh
php artisan migrate --seed
```

**7. Create the Storage Link**

```sh
php artisan storage:link
```

This creates the symbolic link required for publicly accessible uploaded files.

**8. Start the Development Server**

```sh
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

**9. Start the Frontend Development Environment**

If Vite is used by the project:

```sh
npm run dev
```

For a production build:

```sh
npm run build
```

---

### Environment Variables

Timplato uses environment variables to store database credentials, application configuration, authentication credentials, and third-party API keys.

Common configuration variables include:

| Variable               | Description                        |
| ---------------------- | ---------------------------------- |
| `APP_NAME`             | Application name                   |
| `APP_ENV`              | Application environment            |
| `APP_KEY`              | Laravel application encryption key |
| `APP_URL`              | Application URL                    |
| `DB_CONNECTION`        | Database driver                    |
| `DB_HOST`              | MySQL database host                |
| `DB_PORT`              | MySQL database port                |
| `DB_DATABASE`          | MySQL database name                |
| `DB_USERNAME`          | MySQL username                     |
| `DB_PASSWORD`          | MySQL password                     |
| `GOOGLE_CLIENT_ID`     | Google OAuth client ID             |
| `GOOGLE_CLIENT_SECRET` | Google OAuth client secret         |
| `GOOGLE_REDIRECT_URI`  | Google OAuth callback URL          |
| `PAYMONGO_SECRET_KEY`  | PayMongo secret API key            |
| `PAYMONGO_PUBLIC_KEY`  | PayMongo public API key            |
| `Tawk.to`              | Tawk.to integration configuration  |

Example database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=timplato
DB_USERNAME=root
DB_PASSWORD=
```

Example Google OAuth configuration:

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

Example PayMongo configuration:

```env
PAYMONGO_SECRET_KEY=your-secret-key
PAYMONGO_PUBLIC_KEY=your-public-key
```

> **Warning:** Never commit `.env` files, API keys, OAuth credentials, payment credentials, or other sensitive information to the repository.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Usage

### 1. Create a Customer Account

Customers can register for an account using the standard authentication system.

The platform also provides **Continue with Google** through Google OAuth 2.0.

Once authenticated, customers can access their account and shopping features.

### 2. Browse Products

Customers can browse the available kitchenware products through the product catalog.

Products may include:

- Product name
- Description
- Price
- Category
- Product images
- Availability
- Stock information

Customers can search, filter, and browse products according to their preferences.

### 3. Manage the Shopping Cart

Customers can add products to their shopping cart.

Cart functionality includes:

- Adding products
- Removing products
- Updating quantities
- Reviewing cart items
- Calculating order totals
- Proceeding to checkout

### 4. Checkout and Payment

Customers can proceed from the shopping cart to checkout.

Timplato integrates PayMongo to process online payments.

Supported payment methods may include:

- Credit cards
- Debit cards
- GCash

The payment process is handled through PayMongo so that sensitive payment information is not directly stored by Timplato.

### 5. Track Orders

After completing an order, customers can access their order history.

Order information may include:

- Order details
- Payment status
- Order status
- Transaction references
- Order timestamps
- Delivery information

### 6. Submit Reviews and Ratings

Customers can submit product reviews and ratings after purchasing products.

Reviews help other customers evaluate products and provide administrators with feedback regarding product performance.

### 7. Contact Customer Support

Timplato integrates Tawk.to to provide live chat support.

Customers can use the chat interface to ask questions and request assistance regarding products, orders, or other concerns.

### 8. View Business Location

The platform integrates Google Maps to display the location of Timplato's headquarters.

Users can interact with the map and obtain directions.

### 9. Admin Product Management

Authorized administrators can manage the product catalog.

Admin functionality includes:

- Add products
- Edit products
- Delete products
- Manage product categories
- Update prices
- Upload product images
- Manage product availability

### 10. Manage Orders

Administrators can monitor and manage customer orders.

Order management includes:

- Viewing orders
- Updating order status
- Verifying payment status
- Handling cancellations
- Managing fulfillment

### 11. Manage Inventory

Administrators can monitor product inventory.

Inventory management allows administrators to:

- Update stock quantities
- Monitor available products
- Identify low-stock items
- Record inventory changes

### 12. Sales and Analytics

Administrators can review business information through sales and analytics reports.

Reports can provide information about:

- Total sales
- Revenue
- Product performance
- Transaction volume
- Customer activity
- Sales trends

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## System Architecture

Timplato follows a modular, service-oriented architecture implemented within a Laravel-based web application.

The system separates major business capabilities into functional modules such as User Management, Product Catalog, Cart & Checkout, Order Management, Inventory Management, and Administration.

### Frontend Layer

The frontend provides the user-facing interface for customers and administrators.

Technologies include:

- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- AJAX / Fetch API

The frontend handles:

- Product browsing
- Searching
- Authentication interaction
- Cart operations
- Checkout interaction
- Order viewing
- Administrative interfaces

### Application Layer

Laravel provides the main application and business logic layer.

The application layer handles:

- Routing
- Authentication
- Authorization
- Product management
- Cart processing
- Order processing
- Payment integration
- Inventory management
- User management
- Notifications
- Reporting
- Content management

Laravel follows an MVC architecture consisting primarily of:

```text
Routes
   │
   ▼
Controllers
   │
   ▼
Models / Business Logic
   │
   ▼
Eloquent ORM
   │
   ▼
MySQL Database
```

### Integration Layer

The application communicates with external services when specialized functionality is required.

```text
                 Timplato Application
                          │
         ┌────────────────┼────────────────┐
         │                │                │
         ▼                ▼                ▼
   Google OAuth        PayMongo          Tawk.to
   Authentication       Payments        Live Chat
         │                │                │
         └────────────────┼────────────────┘
                          │
                          ▼
                    Google Maps
```

### Data Layer

MySQL serves as the primary relational database.

Laravel's Eloquent ORM provides model-based interaction with database tables while maintaining relationships and application-level data handling.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Database Structure

Timplato uses MySQL as its primary relational database.

The database is designed using relational principles and follows a normalized structure to reduce redundancy and maintain data integrity.

### Core Entities

The system contains data related to:

- Users
- Products
- Categories
- Inventory
- Cart
- Orders
- Order Items
- Payments
- Reviews
- Notifications
- Content
- Audit Records

### Core Relationships

```text
User
 │
 ├──────────────► Cart
 │                  │
 │                  └──────────► Product
 │
 ├──────────────► Order
 │                  │
 │                  ├──────────► Order Items
 │                  │                  │
 │                  │                  └──────► Product
 │                  │
 │                  └──────────► Payment
 │
 ├──────────────► Review
 │                  │
 │                  └──────────► Product
 │
 └──────────────► Notification

Product
 │
 ├──────────────► Category
 │
 └──────────────► Inventory
```

The relational structure allows the application to maintain connections between customers, products, orders, payments, inventory, and other e-commerce operations.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Integrations

Timplato integrates several external services to extend the capabilities of the core application.

### Google OAuth 2.0

Google OAuth 2.0 allows customers to register and authenticate using their Google accounts.

The authentication flow is handled through Laravel Socialite.

```text
Customer
   │
   ▼
Continue with Google
   │
   ▼
Laravel Socialite
   │
   ▼
Google OAuth 2.0
   │
   ▼
Verified User Information
   │
   ▼
Timplato Account / Session
```

### PayMongo

PayMongo provides the platform's online payment processing capability.

The integration supports payment methods such as:

- Credit cards
- Debit cards
- GCash

The payment process is handled externally by PayMongo, reducing the need for Timplato to directly handle sensitive payment information.

```text
Customer
   │
   ▼
Checkout
   │
   ▼
Laravel Backend
   │
   ▼
PayMongo API
   │
   ▼
Payment Processing
   │
   ▼
Payment Status
   │
   ▼
Timplato Order
```

### Tawk.to

Tawk.to provides live chat functionality for customer support.

The Tawk.to interface is integrated into the website through the frontend.

```text
Customer
   │
   ▼
Timplato Website
   │
   ▼
Tawk.to
   │
   ▼
Live Chat / Support
```

### Google Maps

Google Maps is integrated to display Timplato's headquarters location.

Users can interact with the map to view the business location and obtain directions.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Authentication & Security

Timplato implements several security mechanisms to protect users, transactions, and administrative resources.

### Authentication

The system supports:

- Laravel authentication
- Google OAuth 2.0
- Laravel Socialite
- Session management
- Password hashing

### Authorization

Role-based access control separates customer and administrative functionality.

Administrators can access management modules while customers are limited to their permitted shopping and account features.

### Password Security

User passwords are not stored as plain text.

Laravel's authentication system provides secure password hashing before credentials are stored in the database.

### CSRF Protection

Laravel's CSRF middleware helps protect application requests against cross-site request forgery attacks.

### Payment Security

Payment processing is delegated to PayMongo.

Timplato does not need to directly store sensitive card or e-wallet information.

### HTTPS

Production deployments should use HTTPS to encrypt communication between users and the application.

### Audit Trail

Administrative activities can be recorded through the audit trail to improve accountability, monitoring, and security.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## API & Integration Documentation

Timplato integrates external services for authentication, payment processing, customer support, and location services.

The primary integrations are:

| Integration      | Purpose             | Technology        |
| ---------------- | ------------------- | ----------------- |
| Google OAuth 2.0 | User authentication | Laravel Socialite |
| PayMongo         | Online payments     | REST API          |
| Tawk.to          | Customer support    | Front-end API     |
| Google Maps      | Business location   | Maps API          |

The Laravel application also provides backend request handling and REST-oriented communication between application components and integrated services.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Roadmap

- [x] Customer authentication
- [x] Google OAuth authentication
- [x] Product catalog
- [x] Product search and filtering
- [x] Shopping cart
- [x] Checkout
- [x] PayMongo payment integration
- [x] Order management
- [x] Order history
- [x] Inventory management
- [x] User management
- [x] Product reviews and ratings
- [x] Sales and analytics reports
- [x] Content management
- [x] Notification management
- [x] Audit trail
- [x] Tawk.to customer support
- [x] Google Maps integration
- [x] Responsive web interface
- [x] Docker support
- [x] Cloud deployment
- [ ] Dedicated mobile application
- [ ] Personalized product recommendations
- [ ] Loyalty and rewards program
- [ ] Supplier management expansion
- [ ] Advanced analytics
- [ ] Delivery tracking integration
- [ ] Expansion to additional Southeast Asian markets

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Contributing

Contributions are welcome and appreciated.

1. Fork the Project
2. Create your Feature Branch

    ```sh
    git checkout -b feature/AmazingFeature
    ```

3. Commit your Changes

    ```sh
    git commit -m "Add AmazingFeature"
    ```

4. Push to the Branch

    ```sh
    git push origin feature/AmazingFeature
    ```

5. Open a Pull Request

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## License

Distributed under the MIT License. See `LICENSE` for more information.

---

## Contact

**Project:** Timplato – A Systems Integration Approach to E-commerce for Filipino Kitchenware

**Project Repository:**

```text
https://github.com/ralphgacusan/timplato
```

**Project Demo:**

```text
https://timplato-djia.onrender.com/
```

**Institution:**

```text
Technological Institute of the Philippines – Quezon City
College of Computer Studies
Information Technology Department
```

**Course:**

```text
IT 009 – Systems Integration and Architecture 1
```

**Section:**

```text
IT31S2
```

---

## Acknowledgments

- Laravel
- PHP
- MySQL
- JavaScript
- Bootstrap
- Google OAuth 2.0
- Laravel Socialite
- PayMongo
- Tawk.to
- Google Maps
- Git
- GitHub
- Docker
- Render
- Railway
- Hostinger

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- MARKDOWN LINKS & IMAGES -->
