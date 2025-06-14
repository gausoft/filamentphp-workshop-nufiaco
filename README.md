# FilamentPHP Workshop - Nufia.co

FilamentPHP workshop project to learn how to create modern administration interfaces with Laravel and FilamentPHP.

## Prerequisites

Before getting started, make sure you have the following installed on your system:

### Required Software
- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** >= 18.x and **npm** (for frontend asset compilation)
- **SQLite** (project's default database)

### Required PHP Extensions
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- PDO SQLite PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Prerequisites Verification
You can verify that PHP and Composer are properly installed with:
```bash
php --version
composer --version
node --version
npm --version
```

## Installation

Follow these steps to install and configure the project locally:

### 1. Fork and Clone the repository
```bash
git clone https://github.com/[username]/filamentphp-workshop-nufiaco.git
cd filamentphp-workshop-nufiaco
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Configure the environment
```bash
# Copy the environment file
cp .env.example .env

# Generate Laravel application key
php artisan key:generate
```

### 4. Prepare the database
The SQLite database is already created in the `database/` folder. If needed, you can recreate it:
```bash
touch database/database.sqlite
php artisan migrate
```

### 5. Install frontend dependencies
```bash
npm install
```

### 6. Start the application
To start both the backend server and frontend development server, use the following command:

```bash
composer dev
```

This command starts simultaneously:
- **Laravel Server** (http://localhost:8000)
- **Vite Development Server** (for asset hot-reload)
- **Queue listener** (to process background jobs)
- **Laravel Pail** (for real-time log monitoring)


# 🚀 FilamentPHP

This project demonstrates how to quickly build a modern admin dashboard using [FilamentPHP](https://filamentphp.com/). It includes user authentication, CRUD for customers, and dashboard widgets — all within a Laravel app using SQLite.

---

## Step 1 – Install FilamentPHP

Install the Filament package with its panel system:

```bash
composer require filament/filament:"^3.3" -W
php artisan filament:install --panels
```

## Step 2 – Create an Admin User

Use the Filament command to create an admin account:

```bash
php artisan make:filament-user
```

Enter email, name, and password when prompted.

---

## Step 3 – Test the Admin Panel

Then visit:
👉 [http://localhost:8000/admin](http://localhost:8000/admin)

Log in with the credentials you created.

---

## Step 4 – Generate Customer CRUD

Create the model and migration:

```bash
php artisan make:model Customer -mf
```

Update the migration file (example):

```php
$table->id();
$table->string('full_name');
$table->string('phone')->nullable();
$table->string('email')->unique();
$table->string('address')->nullable();
$table->string('company')->nullable();
$table->timestamps();
```

Run the migration:

```bash
php artisan migrate
```

Generate the Filament resource:

```bash
php artisan make:filament-resource Customer --generate
```

The `Customer` CRUD is now fully functional in your admin panel.

---

## Step 5 – Add Dashboard Widgets

Generate a stats widget:

```bash
php artisan make:filament-widget CustomerStats --stats-overview
```

Update the widget to show key metrics (example):

```php
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;

return [
    Card::make('Total Customers', Customer::count()),
    Card::make('Active Plans', '42'),
    Card::make('Orders Today', '17'),
    Card::make('Pending Issues', '3'),
];
```

Register your widget in the dashboard panel or a custom page.

---
