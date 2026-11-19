# PONNUS: Laravel Practical Learning Guide
**A Step-by-Step Educational Handbook for Modern PHP & Laravel Development**

---

## Table of Contents
1. [Introduction to Laravel](#1-introduction-to-laravel)
2. [Installing and Configuring Laravel](#2-installing-and-configuring-laravel)
3. [Connecting Laravel to MySQL](#3-connecting-laravel-to-mysql)
4. [Installing and Configuring Laravel Jetstream](#4-installing-and-configuring-laravel-jetstream)
5. [Understanding Laravel Migrations](#5-understanding-laravel-migrations)
6. [Creating Database Tables (Users & Menus)](#6-creating-database-tables-users--menus)
7. [Running Database Migrations](#7-running-database-migrations)
8. [Creating and Understanding Eloquent Models](#8-creating-and-understanding-eloquent-models)
9. [Creating and Understanding Controllers](#9-creating-and-understanding-controllers)
10. [Understanding Routes and HTTP Verbs](#10-understanding-routes-and-http-verbs)
11. [Connecting Routes to Controllers](#11-connecting-routes-to-controllers)
12. [Understanding Blade Templates and Layout Inheritance](#12-understanding-blade-templates-and-layout-inheritance)
13. [Displaying Database Records (Read Operation)](#13-displaying-database-records-read-operation)
14. [Creating HTML Forms with CSRF Protection](#14-creating-html-forms-with-csrf-protection)
15. [Saving Records to MySQL (Create Operation)](#15-saving-records-to-mysql-create-operation)
16. [Updating Records via Method Spoofing (Update Operation)](#16-updating-records-via-method-spoofing-update-operation)
17. [Deleting Records with Confirmation (Delete Operation)](#17-deleting-records-with-confirmation-delete-operation)
18. [Understanding Authentication in Laravel](#18-understanding-authentication-in-laravel)
19. [Understanding Middleware and Route Protection](#19-understanding-middleware-and-route-protection)
20. [Creating Database Seeders for Demo Data](#20-creating-database-seeders-for-demo-data)

---

## 1. Introduction to Laravel

### What it means
Laravel is an open-source PHP web framework created by Taylor Otwell. It follows the **Model-View-Controller (MVC)** architectural pattern and provides expressive, elegant syntax that turns repetitive development tasks (routing, authentication, sessions, caching, database abstraction) into clean, maintainable code.

### Why it is necessary
Building dynamic web applications with raw PHP ("vanilla PHP") requires writing repetitive code for database connections, SQL query sanitization, URL parsing, session security, password hashing, and HTML escaping. Laravel handles these security and infrastructure fundamentals out-of-the-box, allowing developers to focus on the unique business logic of their application—such as managing restaurant dishes.

### How MVC works in Ponnus
- **Model (`app/Models/Menu.php`)**: Interacts with the `menus` table in MySQL.
- **View (`resources/views/dashboard/menu.blade.php`)**: Renders the Bootstrap 5 user interface presented to the user.
- **Controller (`app/Http/Controllers/MenuController.php`)**: Coordinates the flow—receiving browser HTTP requests, talking to the model, and returning the view with data.

---

## 2. Installing and Configuring Laravel

### What it means
A Laravel project is initiated using **Composer**, the standard dependency manager for PHP. When you create a new Laravel project, Composer downloads the framework core and its supporting libraries into a standardized directory structure.

### Why it is necessary
Setting up a structured skeleton ensures PSR-4 autoloading works automatically, external packages can be tracked through `composer.json` and `composer.lock`, and environment variables remain separated from application source code.

### Files Involved
- `composer.json`: Defines PHP and package dependencies.
- `.env`: Holds machine-specific environment configurations (database credentials, application keys, debug mode).
- `.env.example`: The template committed to version control.

### Relevant Code & Commands
```bash
# Check prerequisite versions
php -v
composer -V

# Create the project skeleton
composer create-project laravel/laravel ponnus --prefer-dist
```

### How the code works
Composer resolves dependencies listed in `composer.json`, clones compatible components, sets up class autoloading in `vendor/autoload.php`, and runs `php artisan key:generate` to populate `APP_KEY` in your `.env` file (used for session encryption and secure cookie signing).

---

## 3. Connecting Laravel to MySQL

### What it means
Laravel uses the **PHP Data Objects (PDO)** extension to connect to relational databases. Rather than writing raw connection strings, configuration parameters are isolated inside `.env` and consumed by `config/database.php`.

### Why it is necessary
Hardcoding credentials inside code creates critical security leaks and makes deploying across local development, staging, and production environments difficult. The `.env` file is excluded from Git (`.gitignore`), keeping credentials safe.

### File Involved
- `.env`

### Relevant Code from Ponnus
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ponnus
DB_USERNAME=root
DB_PASSWORD=
```

### How the code works
When Laravel boots, `config/database.php` reads these values using `env('DB_CONNECTION', 'mysql')` and configures a PDO instance. When Eloquent models or query builders execute queries, they query the `ponnus` database running on `127.0.0.1:3306`.

---

## 4. Installing and Configuring Laravel Jetstream

### What it means
**Laravel Jetstream** is an application starter kit that provides a robust starting point for modern Laravel applications. It provides pre-built user authentication, user registration, email verification, two-factor authentication (2FA), session management, and optional API support.

### Why it is necessary
Rebuilding user login, registration, password hashing, password reset tokens, and remember-me cookies from scratch is time-consuming and error-prone. Jetstream provides battle-tested security built on **Laravel Fortify** and **Livewire**.

### Commands Used
```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --no-interaction
npm install
npm run build
```

### Files Involved
- `config/jetstream.php`: Configures active features (profile photos, terms of service, API tokens).
- `config/fortify.php`: Configures authentication backends and route actions.
- `app/Actions/Fortify/CreateNewUser.php`: Handles new user registration logic.

### How the code works
Jetstream publishes Livewire components and backend Fortify actions. When a visitor visits `/login` or `/register`, Fortify executes validation rules, hashes passwords using `Hash::make()`, verifies credentials, and issues an authenticated session cookie.

---

## 5. Understanding Laravel Migrations

### What it means
A **Migration** is version control for your database. Instead of manually creating tables using phpMyAdmin or raw SQL scripts, migrations define schema changes in structured PHP files that can be run, shared across team members, and rolled back at any time.

### Why it is necessary
Manual database changes lead to out-of-sync schemas between developers and production servers. Migrations ensure that every environment running the application has the exact same database structure.

### Files Involved
- `database/migrations/`
- `database/migrations/0001_01_01_000000_create_users_table.php`
- `database/migrations/2026_11_19_000001_create_menus_table.php`

---

## 6. Creating Database Tables (Users & Menus)

### What it means
Using Laravel's `Schema` builder and `Blueprint` class, you define columns, data types, indexes, and constraints in the `up()` method of a migration.

### Why it is necessary
This defines the exact database table blueprint for storing users (with their administrative roles) and restaurant menu items.

### Files Involved
1. `database/migrations/0001_01_01_000000_create_users_table.php`
2. `database/migrations/2026_11_19_000001_create_menus_table.php`

### Relevant Code from Ponnus

#### Extended Users Table:
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('role')->default('Staff'); // Simple role attribute: Admin, Staff, Manager
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->foreignId('current_team_id')->nullable();
    $table->string('profile_photo_path', 2048)->nullable();
    $table->timestamps();
});
```

#### Menus Table:
```php
Schema::create('menus', function (Blueprint $table) {
    $table->id();                                    // Primary auto-incrementing key
    $table->string('name');                           // Dish name (e.g. Chicken Pilau)
    $table->text('description')->nullable();         // Extended description
    $table->string('category');                      // Category (Main Course, Beverages, etc.)
    $table->decimal('price', 8, 2);                  // Currency amount: 8 digits total, 2 decimals
    $table->string('availability')->default('Available'); // 'Available' or 'Unavailable'
    $table->timestamps();                            // created_at & updated_at timestamps
});
```

### How the code works
- `$table->id()` generates an auto-incrementing `BIGINT UNSIGNED PRIMARY KEY`.
- `$table->string('column')` generates a `VARCHAR(255)`.
- `$table->decimal('price', 8, 2)` generates `DECIMAL(8,2)` to avoid floating-point rounding errors in currency.
- `$table->timestamps()` automatically creates `created_at` and `updated_at` DATETIME columns that Eloquent maintains automatically.

---

## 7. Running Database Migrations

### What it means
Executing the Artisan `migrate` command reads all pending migration files in chronological order and translates them into MySQL `CREATE TABLE` and `ALTER TABLE` statements.

### Why it is necessary
This actually creates the physical tables in MySQL.

### Commands Used
```bash
# Run all pending migrations
php artisan migrate

# Roll back all tables, re-run all migrations, and run seeders
php artisan migrate:fresh --seed
```

### How the code works
Laravel creates a special internal `migrations` table in MySQL to track which migration files have already executed. `migrate:fresh` drops all tables in the database and re-runs every migration from scratch, ensuring a pristine schema.

---

## 8. Creating and Understanding Eloquent Models

### What it means
An **Eloquent Model** is an Object-Relational Mapper (ORM) class that represents a specific database table. An instance of a model corresponds directly to a single row in that table.

### Why it is necessary
Instead of writing complex SQL queries like `SELECT * FROM menus WHERE id = 1` or `INSERT INTO menus...`, you interact with data using expressive PHP objects and methods: `Menu::all()`, `Menu::find(1)`, `$menu->save()`, and `$menu->delete()`.

### File Involved
- `app/Models/Menu.php`

### Relevant Code from Ponnus
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Explicitly defining the database table name
    protected $table = 'menus';

    // Mass-assignment protection: specifies which attributes may be safely filled
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'availability',
    ];

    // Attribute casting: ensures 'price' is always formatted as a 2-decimal string/number
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
```

### Understanding `$fillable`
In Laravel, **Mass Assignment** occurs when an associative array is passed directly into a model, such as `Menu::create($request->all())`. If unconstrained, malicious users could tamper with HTTP POST payloads to inject arbitrary columns (e.g. `is_admin = 1`). The `$fillable` array acts as an explicit allow-list of attributes that may be mass-assigned.

---

## 9. Creating and Understanding Controllers

### What it means
A **Controller** is the central coordinator in MVC. It encapsulates HTTP request handling logic for a specific resource, queries or updates Eloquent models, and determines the HTTP response (such as rendering a Blade view or redirecting).

### Why it is necessary
Without controllers, all application logic would clutter `routes/web.php`. Controllers group related request handling logic into readable, testable methods.

### File Involved
- `app/Http/Controllers/MenuController.php`

### Deliberate Teaching Convention in Ponnus
In this educational project, a deliberate custom method convention is implemented:
- `index()`: Displays the form to add a new menu item.
- `create()`: Displays the list table of all menu items.
- `store()`: Persists a newly submitted menu item to MySQL.
- `edit($id)`: Displays the edit form for an existing menu item.
- `update($request, $id)`: Persists changes to an existing item.
- `destroy($id)`: Removes an item from the database.

### Relevant Code from Ponnus
```php
class MenuController extends Controller
{
    public function index()
    {
        return view('dashboard.add-menu');
    }

    public function create()
    {
        $menus = Menu::all();
        return view('dashboard.menu', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'category'     => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'availability' => 'required|in:Available,Unavailable',
        ]);

        $menu = new Menu();
        $menu->name         = $request->input('name');
        $menu->description  = $request->input('description');
        $menu->category     = $request->input('category');
        $menu->price        = $request->input('price');
        $menu->availability = $request->input('availability');
        $menu->save();

        return redirect()->back()->with('success', 'Menu item "' . $menu->name . '" created successfully!');
    }
}
```

### How the code works
1. **Request Injection**: `Request $request` gives access to validated HTTP input data.
2. **`$request->input('key')`**: Safely retrieves submitted form values.
3. **Property Assignment & `save()`**: Assigning `$menu->name = ...` and calling `$menu->save()` generates and runs the SQL `INSERT` statement.
4. **`compact('menus')`**: Creates an array `['menus' => $menus]` to pass the data into the Blade view.
5. **`redirect()->back()->with('success', ...)`**: Sets a temporary session "flash" message displayed upon redirect.

---

## 10. Understanding Routes and HTTP Verbs

### What it means
A **Route** defines how the application responds to a client's HTTP request to a specific Uniform Resource Identifier (URI) and HTTP verb (`GET`, `POST`, `PUT`, `DELETE`).

### Why it is necessary
Routes connect the browser URL entered by a user with the appropriate backend controller action.

### The Core HTTP Verbs
- `GET`: Safe, read-only requests. Used for loading pages and displaying tables/forms.
- `POST`: Used for submitting new records to be created.
- `PUT`: Used for replacing/updating an existing record.
- `DELETE`: Used for removing an existing record.

---

## 11. Connecting Routes to Controllers

### What it means
Rather than defining closure callbacks in the route file, routes point directly to controller action methods using PHP callable syntax: `[MenuController::class, 'methodName']` or controller route groups.

### Why it is necessary
Organizing routes with **Controller Route Groups** avoids repeating controller class names and prefixes, and enforces authentication requirements globally across all menu endpoints.

### File Involved
- `routes/web.php`

### Relevant Code from Ponnus
```php
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Controller-based route group (no Route::resource())
    Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
        Route::get('/create', 'index')->name('index');        // GET /menu/create -> MenuController@index
        Route::get('/list', 'create')->name('create');        // GET /menu/list   -> MenuController@create
        Route::get('/show/{id}', 'show')->name('show');       // GET /menu/show/1 -> MenuController@show (Single item view)
        Route::get('/edit/{id}', 'edit')->name('edit');       // GET /menu/edit/1 -> MenuController@edit
        Route::post('/store', 'store')->name('store');         // POST /menu/store -> MenuController@store
        Route::put('/update/{id}', 'update')->name('update'); // PUT /menu/update/1 -> MenuController@update
        Route::delete('/delete/{id}', 'destroy')->name('destroy'); // DELETE /menu/delete/1 -> MenuController@destroy
    });
});
```

### Why Named Routes are Essential
Using named routes like `route('menu.create')` in Blade templates decouples your view links from URL paths. If the URL path is changed tomorrow from `/menu/list` to `/dishes`, all Blade templates automatically adapt without manual search-and-replace!

---

## 12. Understanding Blade Templates and Layout Inheritance

### What it means
**Blade** is Laravel's lightweight templating engine. Blade views are compiled into plain PHP code and cached for performance. Blade allows template inheritance, component re-use, and clear directives without verbose PHP tags (`<?php echo ... ?>`).

### Why it is necessary
Without layouts, common UI elements (HTML head, Bootstrap CSS links, sidebar navigation, top navbar, footer) would need to be duplicated in every single file, making maintenance nearly impossible.

### Key Directives Demonstrated
- `@extends('dashboard.layouts.master')`: Inherits the master HTML skeleton.
- `@section('content')` & `@endsection`: Defines the dynamic body content for that page.
- `@yield('content')`: Designates where child section content appears in the master layout.
- `@include('dashboard.navbar')`: Embeds a partial view snippet directly.
- `@foreach ($menus as $item)`: Loops through Eloquent collection records.
- `@if` / `@else` / `@endif`: Conditional display logic.
- `@csrf`: Inserts the hidden Cross-Site Request Forgery security token.
- `@method('PUT')` / `@method('DELETE')`: HTTP verb method spoofing for forms.

### Master Layout Structure in Ponnus
```
resources/views/dashboard/
├── layouts/
│   └── master.blade.php   <-- Master skeleton, Bootstrap 5 CDN, yields content
├── navbar.blade.php       <-- Top bar with user name, role badge, logout
├── sidebar.blade.php      <-- Navigation links to Dashboard & Menu operations
├── index.blade.php        <-- Restaurant Dashboard summary cards
├── menu.blade.php         <-- Menu items list table with view/edit/delete actions
├── show-menu.blade.php    <-- Single menu item detail view page
├── add-menu.blade.php     <-- Form for creating a new menu item
└── edit-menu.blade.php    <-- Form for updating an existing menu item
```

---

## 13. Displaying Database Records (Read Operation)

### What it means
Retrieving records from the database using Eloquent and passing them into a Blade view to be iterated into a formatted Bootstrap HTML table.

### Files Involved
- `app/Http/Controllers/MenuController.php` (method: `create()`)
- `resources/views/dashboard/menu.blade.php`

### Relevant Code

#### Controller (`create()` method):
```php
public function create()
{
    // Retrieve all records from the 'menus' table
    $menus = Menu::all();

    // Pass $menus to resources/views/dashboard/menu.blade.php
    return view('dashboard.menu', compact('menus'));
}
```

#### Blade View (`resources/views/dashboard/menu.blade.php`):
```blade
<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($menus as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><strong>{{ $item->name }}</strong></td>
                <td><span class="badge bg-info">{{ $item->category }}</span></td>
                <td>{{ $item->description }}</td>
                <td>UGX {{ number_format($item->price, 0) }}</td>
                <td>
                    @if ($item->availability === 'Available')
                        <span class="badge bg-success">Available</span>
                    @else
                        <span class="badge bg-secondary">Unavailable</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <!-- Delete button triggering confirmation modal -->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

## 14. Creating HTML Forms with CSRF Protection

### What it means
An HTML form sends submitted input data to the web server. In Laravel, every form that submits data (`POST`, `PUT`, `PATCH`, `DELETE`) **must** include a `@csrf` directive.

### Why it is necessary
Cross-Site Request Forgery (CSRF) is an exploit where unauthorized commands are submitted from an external site that the user trusts. Laravel's `VerifyCsrfToken` middleware generates and verifies a secret session token for every request, rejecting forged requests with HTTP `419 Page Expired`.

### File Involved
- `resources/views/dashboard/add-menu.blade.php`

### Relevant Code
```blade
<form method="POST" action="{{ route('menu.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Item Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Additional fields for category, price, availability, description -->

    <button type="submit" class="btn btn-warning">Save Menu Item</button>
</form>
```

---

## 15. Saving Records to MySQL (Create Operation)

### What it means
Validating incoming request data, instantiating an Eloquent model instance, assigning form values individually to model properties, and persisting the record to MySQL via `save()`.

### Files Involved
- `app/Http/Controllers/MenuController.php` (method: `store()`)
- `app/Models/Menu.php`

### Relevant Code
```php
public function store(Request $request)
{
    // 1. Basic validation rules
    $request->validate([
        'name'         => 'required|string|max:255',
        'description'  => 'nullable|string',
        'category'     => 'required|string|max:100',
        'price'        => 'required|numeric|min:0',
        'availability' => 'required|in:Available,Unavailable',
    ]);

    // 2. Instantiate model
    $menu = new Menu();

    // 3. Assign values individually using $request->input()
    $menu->name         = $request->input('name');
    $menu->description  = $request->input('description');
    $menu->category     = $request->input('category');
    $menu->price        = $request->input('price');
    $menu->availability = $request->input('availability');

    // 4. Persist to database
    $menu->save();

    // 5. Flash message and redirect
    return redirect()->back()->with('success', 'Menu item "' . $menu->name . '" created successfully!');
}
```

### How the code works
If validation fails, Laravel halts execution and automatically redirects the browser back to the form, populating `$errors` and preserving user input via `old()`. When valid, `$menu->save()` issues an SQL `INSERT INTO menus (...) VALUES (...)` query.

---

## 16. Updating Records via Method Spoofing (Update Operation)

### What it means
Retrieving an existing record with `findOrFail($id)`, updating its attributes with validated request data, and persisting the changes via `save()`.

### Why Method Spoofing is Necessary
Standard HTML `<form>` tags only support `GET` and `POST` methods. To send an HTTP `PUT` request to `Route::put()`, Laravel uses **Method Spoofing**: `@method('PUT')` adds a hidden input `<input type="hidden" name="_method" value="PUT">` that Laravel's router recognizes.

### Files Involved
- `resources/views/dashboard/edit-menu.blade.php`
- `app/Http/Controllers/MenuController.php` (methods: `edit()` and `update()`)

### Relevant Code

#### Controller:
```php
public function edit($id)
{
    $menu = Menu::findOrFail($id);
    return view('dashboard.edit-menu', compact('menu'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'description'  => 'nullable|string',
        'category'     => 'required|string|max:100',
        'price'        => 'required|numeric|min:0',
        'availability' => 'required|in:Available,Unavailable',
    ]);

    $menu = Menu::findOrFail($id);
    $menu->name         = $request->input('name');
    $menu->description  = $request->input('description');
    $menu->category     = $request->input('category');
    $menu->price        = $request->input('price');
    $menu->availability = $request->input('availability');
    $menu->save();

    return redirect()->back()->with('success', 'Menu item "' . $menu->name . '" updated successfully!');
}
```

#### Blade Form:
```blade
<form method="POST" action="{{ route('menu.update', $menu->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="form-control" required>
    <!-- Remaining fields -->
    <button type="submit" class="btn btn-primary">Update Menu Item</button>
</form>
```

---

## 17. Deleting Records with Confirmation (Delete Operation)

### What it means
Removing a database record using Eloquent's `delete()` method after requiring explicit user confirmation to prevent accidental data loss.

### Files Involved
- `resources/views/dashboard/menu.blade.php`
- `app/Http/Controllers/MenuController.php` (method: `destroy()`)

### Relevant Code

#### Controller:
```php
public function destroy($id)
{
    $menu = Menu::findOrFail($id);
    $itemName = $menu->name;
    $menu->delete();

    return redirect()->back()->with('success', 'Menu item "' . $itemName . '" deleted successfully!');
}
```

#### Blade & JavaScript Delete Modal Confirmation:
```blade
<!-- Delete Trigger Button -->
<button type="button" class="btn btn-outline-danger btn-delete" 
        data-name="{{ $item->name }}" 
        data-url="{{ route('menu.destroy', $item->id) }}">
    <i class="bi bi-trash"></i>
</button>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5>Confirm Deletion</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteItemName"></strong>?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-delete').on('click', function() {
            var itemName = $(this).data('name');
            var actionUrl = $(this).data('url');
            $('#deleteItemName').text(itemName);
            $('#deleteForm').attr('action', actionUrl);
            new bootstrap.Modal('#deleteConfirmModal').show();
        });
    });
</script>
```

---

## 18. Understanding Authentication in Laravel

### What it means
Authentication is the process of verifying that users are who they claim to be. In Ponnus, Laravel Jetstream handles user registration, login authentication, session management, and password hashing using bcrypt.

### How Jetstream Manages Sessions
1. A user submits their email and password to `/login`.
2. Laravel Fortify locates the user record in MySQL and verifies the hashed password using `Hash::check()`.
3. If valid, an authenticated session ID is created and stored in the `sessions` database table, and an encrypted session cookie is sent to the client browser.
4. On every subsequent HTTP request, Laravel matches the session cookie with the session in MySQL, providing the authenticated user object via `Auth::user()`.

### Displaying User Name & Role in Blade
```blade
<div class="fw-bold">{{ Auth::user()->name }}</div>
<span class="badge bg-primary">Role: {{ Auth::user()->role }}</span>
```

---

## 19. Understanding Middleware and Route Protection

### What it means
**Middleware** provides a convenient mechanism for inspecting and filtering HTTP requests entering your application.

### Why it is necessary
Protected administrative areas like `/dashboard` and `/menu/*` must be strictly inaccessible to unauthenticated guests.

### File Involved
- `routes/web.php`

### Relevant Code
```php
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // All routes inside here require an active authenticated session
});
```

### How the code works
When a guest visits `/menu/list`:
1. The request encounters the `auth:sanctum` middleware.
2. The middleware inspects `Auth::check()`.
3. Because the user is not logged in, the middleware interrupts the request and returns an HTTP 302 redirect to the named route `login`.
4. The user is redirected to the Jetstream login screen with an intended redirect URL stored in session memory.

---

## 20. Creating Database Seeders for Demo Data

### What it means
A **Database Seeder** is a PHP class that populates the database with initial demonstration records using Eloquent models or query builders.

### Why it is necessary
Rather than manually typing demo users and menu items through the browser after every migration, seeders populate realistic sample data with a single command.

### Files Involved
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/UserSeeder.php`
- `database/seeders/MenuSeeder.php`

### Relevant Code

#### `database/seeders/UserSeeder.php`:
```php
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Restaurant Administrator',
                'email'    => 'admin@ponnus.test',
                'role'     => 'Admin',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'Restaurant Staff',
                'email'    => 'staff@ponnus.test',
                'role'     => 'Staff',
                'password' => Hash::make('password123'),
            ],
            [
                'name'     => 'Restaurant Manager',
                'email'    => 'manager@ponnus.test',
                'role'     => 'Manager',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(['email' => $userData['email']], $userData);
        }
    }
}
```

#### `database/seeders/MenuSeeder.php`:
```php
class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name'         => 'Chicken Pilau',
                'description'  => 'Fragrant spiced basmati rice cooked with tender pieces of marinated chicken and authentic spices.',
                'category'     => 'Main Course',
                'price'        => 15000,
                'availability' => 'Available',
            ],
            [
                'name'         => 'Beef Burger',
                'description'  => 'Juicy flame-grilled beef patty served in a brioche bun with cheddar, lettuce, and tomatoes.',
                'category'     => 'Fast Food',
                'price'        => 18000,
                'availability' => 'Available',
            ],
            [
                'name'         => 'Vegetable Pizza',
                'description'  => 'Crispy artisan pizza topped with tomato sauce, mozzarella, bell peppers, olives, and mushrooms.',
                'category'     => 'Pizza',
                'price'        => 25000,
                'availability' => 'Available',
            ],
            [
                'name'         => 'Fresh Juice',
                'description'  => 'Freshly extracted chilled seasonal passion fruit and orange juice with mint.',
                'category'     => 'Beverages',
                'price'        => 5000,
                'availability' => 'Available',
            ],
            [
                'name'         => 'Grilled Chicken',
                'description'  => 'Half chicken marinated in garlic and lemon, char-grilled to tenderness.',
                'category'     => 'Main Course',
                'price'        => 28000,
                'availability' => 'Unavailable',
            ],
        ];

        foreach ($items as $item) {
            Menu::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
```

#### Calling Seeders from `DatabaseSeeder.php`:
```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        MenuSeeder::class,
    ]);
}
```

### Seeding Command
```bash
php artisan db:seed
```

---

## Summary of Completed Learning Objectives
By studying and building the Ponnus application, a student understands:
1. How browser HTTP requests match declared routes in `routes/web.php`.
2. How authentication middleware protects routes.
3. How controllers validate input and coordinate actions.
4. How Eloquent models map to MySQL tables and perform full CRUD operations.
5. How Blade templates use inheritance, components, and directives for clean UI rendering.
6. How database migrations and seeders version-control and populate application data.
