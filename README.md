# PONNUS - Restaurant Menu Management System
### Laravel Practical Learning Project

Ponnus is an educational web-based restaurant menu management application developed using **Laravel**, **Laravel Jetstream** (Livewire stack), **MySQL**, and **Bootstrap 5**.

The project is purpose-built for students and developers learning Laravel fundamentals:
- **Authentication**: Pre-configured user registration, login, logout, password reset, and profile management using Laravel Jetstream.
- **Menu Management (CRUD)**: Full Create, Read, Update, and Delete operations for restaurant dishes and beverages using traditional Laravel MVC architecture and Eloquent ORM.

---

## 1. System Requirements

Ensure the following tools are installed on your workstation:
- **PHP**: `^8.2` or higher (Tested with PHP `8.5.12`)
- **Composer**: `^2.5` or higher (Tested with Composer `2.8.12`)
- **Node.js & NPM**: Node `^18.0` / NPM `^9.0`
- **MySQL / MariaDB**: `^8.0` / `^10.4` (e.g. via XAMPP, Laragon, or standalone service on port `3306`)

---

## 2. Installation & Setup Instructions

Follow these step-by-step terminal commands to set up the project locally.

### Step 1: Clone or Navigate to the Project
```bash
cd C:\Users\MATHEW\Desktop\ponnus
```

### Step 2: Install Composer Dependencies
```bash
composer install
```

### Step 3: Install Frontend Dependencies & Build Assets
```bash
npm install
npm run build
```

---

## 3. Package & Jetstream Installation Reference

For reference, the following commands were used to install Laravel, Jetstream, and the Livewire stack:

```bash
# 1. Project Initialization
composer create-project laravel/laravel ponnus --prefer-dist

# 2. Jetstream Package Installation
composer require laravel/jetstream

# 3. Jetstream Livewire Stack Scaffolding
php artisan jetstream:install livewire --no-interaction

# 4. Compile Frontend Assets
npm install
npm run build
```

---

## 4. Environment & Database Configuration

Copy the sample environment file and generate a unique application encryption key:

```bash
# Copy template if .env does not exist
copy .env.example .env

# Generate Application Key
php artisan key:generate
```

Open your `.env` file and configure your MySQL database connection:

```dotenv
APP_NAME=Ponnus
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ponnus
DB_USERNAME=root
DB_PASSWORD=
```

Ensure MySQL is running (e.g. start MySQL in your XAMPP Control Panel) and create the database if it doesn't already exist:

```sql
CREATE DATABASE IF NOT EXISTS ponnus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 5. Migrations & Database Seeding

Run the migrations to create all required database tables (`users`, `menus`, `sessions`, `password_reset_tokens`, etc.) and seed the initial demonstration accounts and sample dishes:

```bash
# Run fresh migrations with seeders
php artisan migrate:fresh --seed
```

Or run seeders individually at any time:
```bash
php artisan db:seed
```

---

## 6. Demonstration Login Credentials

The database seeder automatically populates three demonstration accounts with distinct restaurant roles. All three accounts share a common demonstration password.

| Name | Email Address | Role | Password |
|---|---|---|---|
| **Restaurant Administrator** | `admin@ponnus.test` | `Admin` | `password123` |
| **Restaurant Staff** | `staff@ponnus.test` | `Staff` | `password123` |
| **Restaurant Manager** | `manager@ponnus.test` | `Manager` | `password123` |

> **Note:** All three demonstration accounts have access to view, add, edit, and delete items in the menu management module.

---

## 7. Sample Menu Items Included

The `MenuSeeder` seeds five initial restaurant items across various food categories:

1. **Chicken Pilau** – *Main Course* – `$12.50` – `Available`
2. **Beef Burger** – *Fast Food* – `$8.99` – `Available`
3. **Vegetable Pizza** – *Pizza* – `$10.50` – `Available`
4. **Fresh Juice** – *Beverages* – `$4.00` – `Available`
5. **Grilled Chicken** – *Main Course* – `$14.00` – `Unavailable`

---

## 8. Starting the Local Application Server

To launch the local PHP development server:

```bash
php artisan serve
```

Once running, access the application in your browser:
- **Landing Page**: [http://localhost:8000](http://localhost:8000)
- **Login Page**: [http://localhost:8000/login](http://localhost:8000/login)
- **Registration Page**: [http://localhost:8000/register](http://localhost:8000/register)
- **Restaurant Dashboard**: [http://localhost:8000/dashboard](http://localhost:8000/dashboard)
- **Menu Items List**: [http://localhost:8000/menu/list](http://localhost:8000/menu/list)
- **Add Menu Item Form**: [http://localhost:8000/menu/create](http://localhost:8000/menu/create)

---

## 9. Application Architecture & File Overview

### Routes (`routes/web.php`)
- Grouped with `auth:sanctum`, Jetstream session, and `verified` middleware.
- Uses `Route::controller(MenuController::class)` with named routes:
  - `menu.index` (`GET /menu/create`): Add-menu form *(educational convention)*
  - `menu.create` (`GET /menu/list`): Menu list table *(educational convention)*
  - `menu.store` (`POST /menu/store`): Save new item
  - `menu.edit` (`GET /menu/edit/{id}`): Edit-menu form
  - `menu.update` (`PUT /menu/update/{id}`): Update existing item
  - `menu.destroy` (`DELETE /menu/delete/{id}`): Delete item

### Controllers
- `app/Http/Controllers/DashboardController.php`: Prepares dashboard statistics (`$totalMenus`, `$availableMenus`, `$unavailableMenus`).
- `app/Http/Controllers/MenuController.php`: Handles CRUD actions, validation, and Eloquent persistence.

### Models
- `app/Models/User.php`: Extended with `$fillable = ['name', 'email', 'password', 'role']`.
- `app/Models/Menu.php`: Eloquent model representing the `menus` table with `$fillable` and attribute casting.

### Blade Views
- `resources/views/dashboard/layouts/master.blade.php`: Master template with Bootstrap 5 CDN, icons, and jQuery.
- `resources/views/dashboard/navbar.blade.php`: Top bar with user name, role badge, profile link, and logout.
- `resources/views/dashboard/sidebar.blade.php`: Responsive side menu navigation.
- `resources/views/dashboard/index.blade.php`: Dashboard showing greeting, role badge, metrics, and quick action links.
- `resources/views/dashboard/menu.blade.php`: Table listing menu items with edit links and delete confirmation modal.
- `resources/views/dashboard/add-menu.blade.php`: Add dish form with CSRF protection and validation errors.
- `resources/views/dashboard/edit-menu.blade.php`: Edit dish form with HTTP `PUT` method spoofing.

---

## 10. Running Automated Tests

To run the automated test suite verifying authentication and CRUD workflows:

```bash
php artisan test tests/Feature/MenuManagementTest.php
```

All 10 feature tests verify:
- Unauthenticated access rejection on protected routes.
- Successful authentication of Admin, Staff, and Manager accounts.
- Listing of all sample dishes.
- Form rendering, validation error handling, creating, updating, and deleting dishes in the database.

---

## 11. Learning Guide

For an in-depth pedagogical walkthrough explaining every Laravel concept, file, and code snippet in educational order, refer to:
**[PONNUS_LARAVEL_LEARNING_GUIDE.md](PONNUS_LARAVEL_LEARNING_GUIDE.md)**
