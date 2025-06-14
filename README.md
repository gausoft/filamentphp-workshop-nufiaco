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

Update the Customer factory to generate fake data:

```php
// database/factories/CustomerFactory.php
public function definition(): array
{
    return [
        'full_name' => fake()->name(),
        'phone' => fake()->phoneNumber(),
        'email' => fake()->unique()->safeEmail(),
        'address' => fake()->address(),
        'company' => fake()->company(),
    ];
}
```

Optionally, seed the database with sample data:

```bash
php artisan tinker

use App\Models\Customer;

Customer::factory(50)->create();
```

Generate the Filament resource:

```bash
php artisan make:filament-resource Customer --generate
```

The `Customer` CRUD is now fully functional in your admin panel.

---

## Step 5 – Add Dashboard Widgets

Create a stats widget for the Customer resource:

```bash
php artisan make:filament-widget CustomerOverview --stats-overview --resource=CustomerResource
```

This creates a widget in `app/Filament/Resources/CustomerResource/Widgets/CustomerOverview.php`.

Update the widget to show customer statistics:

```php
<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count())
                ->description('All registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('New This Month', Customer::whereMonth('created_at', now()->month)->count())
                ->description('Customers added this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
            Stat::make('With Companies', Customer::whereNotNull('company')->count())
                ->description('Customers with company info')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),
        ];
    }
}
```

Register the widget in your Customer resource (`app/Filament/Resources/CustomerResource.php`):

```php
public static function getWidgets(): array
{
    return [
        CustomerResource\Widgets\CustomerOverview::class,
    ];
}
```

Display the widget on the Customer list page (`app/Filament/Resources/CustomerResource/Pages/ListCustomers.php`):

```php
<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerResource\Widgets\CustomerOverview::class,
        ];
    }
}
```

The stats widget will now appear above the customer table, showing key metrics about your customers!

---
