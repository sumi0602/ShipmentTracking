# TrackFlow — Shipment Tracking Application

A production-grade shipment tracking web application built with **PHP 8.3** and **Laravel 11**, featuring server-side rendering, pagination, search, and a full status timeline.

---

## ✨ Features

- **Shipment List** (`/shipments`) — paginated table with search by tracking number
- **Shipment Details** (`/shipments/{id}`) — full sender/receiver info + chronological status timeline
- Clean SSR Blade views — no JS framework dependency
- Scoped Eloquent queries with custom search scope
- Cascading status logs with timestamps and locations
- 50 seeded shipments across all statuses for instant demo

---

## 🛠 Tech Stack

| Layer       | Technology              |
|-------------|-------------------------|
| Language    | PHP 8.3                 |
| Framework   | Laravel 11              |
| Database    | SQLite (dev) / MySQL / PostgreSQL |
| Templating  | Blade (SSR)             |
| Assets      | Vite 5                  |
| Testing     | PHPUnit 11              |

---

## 🚀 Quick Start

### Prerequisites

- PHP **8.3+** with extensions: `pdo`, `pdo_sqlite`, `mbstring`, `xml`, `curl`
- Composer **2.x**
- Node.js **20+** & npm

---

### 1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/shipment-tracker.git
cd shipment-tracker
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database setup (SQLite — zero config)

```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

> **MySQL / PostgreSQL?** Update `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in `.env`, then run the same migrate and seed commands.

### 6. Build assets

```bash
# Development (with hot-reload)
npm run dev

# Production build
npm run build
```

### 7. Start the server

```bash
php artisan serve
```

Visit **http://localhost:8000/shipments** 🎉

---

## 📁 Project Structure

```
app/
├── Http/
│   └── Controllers/
│       └── ShipmentController.php   # index + show actions
├── Models/
│   ├── Shipment.php                 # search scope, status helpers
│   └── StatusLog.php
└── Providers/
    └── AppServiceProvider.php       # custom pagination view

database/
├── factories/
│   ├── ShipmentFactory.php
│   └── StatusLogFactory.php
├── migrations/
│   ├── ..._create_shipments_table.php
│   └── ..._create_status_logs_table.php
└── seeders/
    └── DatabaseSeeder.php           # 50 realistic shipments

resources/views/
├── layouts/app.blade.php            # master layout + all CSS
├── shipments/
│   ├── index.blade.php              # list page
│   └── show.blade.php               # detail page
└── vendor/pagination/custom.blade.php

routes/
└── web.php                          # 2 clean resource routes
```

---

## 🗄 Database Schema

### `shipments`

| Column             | Type         | Notes                          |
|--------------------|--------------|--------------------------------|
| `id`               | bigint PK    | Auto-increment                 |
| `tracking_number`  | varchar(20)  | Unique, indexed                |
| `sender_name`      | varchar      |                                |
| `sender_address`   | text         |                                |
| `receiver_name`    | varchar      |                                |
| `receiver_address` | text         |                                |
| `destination_city` | varchar      |                                |
| `status`           | enum         | Pending / In Transit / Delivered |
| `created_at`       | timestamp    |                                |
| `updated_at`       | timestamp    |                                |

### `status_logs`

| Column        | Type      | Notes                       |
|---------------|-----------|-----------------------------|
| `id`          | bigint PK | Auto-increment              |
| `shipment_id` | bigint FK | → shipments.id (cascade)    |
| `status`      | enum      | Pending / In Transit / Delivered |
| `location`    | varchar   | Human-readable location     |
| `note`        | text      | Optional description        |
| `created_at`  | timestamp |                             |
| `updated_at`  | timestamp |                             |

---

## 🔍 Key Implementation Details

### Search Scope (`Shipment.php`)

```php
public function scopeSearch(Builder $query, ?string $term): Builder
{
    if (blank($term)) {
        return $query;
    }
    return $query->where('tracking_number', 'like', "%{$term}%");
}
```

Used in the controller:

```php
$shipments = Shipment::query()
    ->search($request->string('search')->trim()->value())
    ->latest()
    ->paginate(10)
    ->withQueryString();
```

### Eager Loading (N+1 prevention)

```php
// ShipmentController@show
$shipment->load(['statusLogs']);
```

### Status Enum Constants

```php
Shipment::STATUS_PENDING     // 'Pending'
Shipment::STATUS_IN_TRANSIT  // 'In Transit'
Shipment::STATUS_DELIVERED   // 'Delivered'
Shipment::STATUSES           // full array
```

---

## 🧪 Running Tests

```bash
php artisan test
```

---

## ⚙️ Environment Variables Reference

| Variable        | Default       | Description                    |
|-----------------|---------------|--------------------------------|
| `APP_NAME`      | TrackFlow     | Application name               |
| `APP_ENV`       | local         | `local` / `production`         |
| `APP_DEBUG`     | true          | Show detailed errors           |
| `APP_URL`       | http://localhost | Public app URL              |
| `DB_CONNECTION` | sqlite        | `sqlite` / `mysql` / `pgsql`   |
| `DB_DATABASE`   | *(path)*      | DB name or SQLite file path    |

---

## 🚢 Deployment (Production)

```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set `APP_ENV=production` and `APP_DEBUG=false` in your production `.env`.

---

## 📄 License

MIT
