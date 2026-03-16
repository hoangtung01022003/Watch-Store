# Online Watch Store

## Project Overview

Online Watch Store is an e-commerce website developed to support customers in browsing, selecting, and purchasing watches online.
The system also provides an administrative dashboard that allows administrators to manage products, orders, and customers efficiently.

This project is designed as a university software development project using modern web technologies.

---

# Technology Stack

Backend:

* Laravel 12
* PHP 8+
* MySQL Database

Frontend:

* Blade Template Engine
* TailwindCSS / Bootstrap

Development Tools:

* Composer
* Node.js & NPM
* Git

---

# System Features

## 1. Customer Interface (Front-End)

### Account Management

* User registration
* User login and logout
* Update personal profile information
* Change password

### Home Page & Product Categories

* Display banners
* Display featured products
* Display newest products
* Product categories by brand, gender, or strap material

### Product Details

* Product images
* Product price
* Detailed product description
* Technical specifications (water resistance, case size, etc.)

### Search & Filtering

* Search products by name
* Filter products by brand
* Filter products by price range

### Shopping Cart

* Add products to cart
* Update product quantity
* Remove products from cart
* Display total cart price

### Checkout & Order Placement

* Enter shipping information
* Select payment method (Cash on Delivery - COD)
* Confirm order

### Order History

* View previous orders
* Track order status

---

# 2. Admin Panel

### Admin Authentication

* Secure admin login system

### Dashboard

Overview of system statistics:

* Total products
* Total orders
* Total customers
* Total revenue

### Product & Category Management

* Add new products
* Edit product information
* Delete products
* Upload product images
* Manage product categories and brands
* Update stock quantity

### Order Management

* View all customer orders
* View order details
* Update order status

  * Pending
  * Processing
  * Shipping
  * Completed
  * Cancelled

### Customer Management

* View registered users
* Lock or unlock user accounts

---

# Database Structure

Main tables used in the system:

* users
* products
* categories
* orders
* order_items
* cart_items

---

# Installation Guide

1. Clone the repository

```
git clone https://github.com/your-username/online-watch-store.git
```

2. Navigate to project folder

```
cd online-watch-store
```

3. Install dependencies

```
composer install
npm install
```

4. Configure environment file

```
cp .env.example .env
```

Update database configuration inside `.env`

5. Generate application key

```
php artisan key:generate
```

6. Run migrations

```
php artisan migrate
```

7. Start development server

```
php artisan serve
```

---

# Project Structure

```
app
 ├── Models
 ├── Http
 │   ├── Controllers
 │   │   ├── Admin
 │   │   └── User
 ├── Services

resources
 ├── views
 ├── css
 └── js

routes
 ├── web.php
```

---

# Future Improvements

* Online payment integration
* Product reviews and ratings
* Wishlist feature
* Discount and coupon system
* Advanced product filtering

---

# Author

Student Project – E-commerce Website Development

---

# License

This project is developed for educational purposes.
