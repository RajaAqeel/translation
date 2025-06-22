# 🌐 Translation Management API - Laravel

A performant, secure, and scalable Laravel-based Translation Management Service.

---

## 🛠 Features

- Store translations for multiple locales (e.g., `en`, `fr`, `es`)
- Tag translations with context (`web`, `mobile`, `desktop`)
- Search by key, value, or tags
- Token-based authentication (Laravel Sanctum)
- JSON export endpoint for frontend frameworks like Vue.js
- Command to seed 100k+ translations for performance testing
- PSR-12 & SOLID-compliant architecture

---

## 🚀 Quick Setup

### 1. Clone the Repository

```bash
git clone https://github.com/RajaAqeel/translation.git
cd translation-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
php artisan key:generate
```

### 4. Migrate the Database

```bash
DB_DATABASE=translations
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
```

### 5. Seed with 100k+ Records

```bash
php artisan db:seed-large
```

## 🔐 Authentication (Sanctum)

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"
php artisan migrate
```

```bash
Create a test user:

php artisan tinker
>>> \App\Models\User::create([
...   'name' => 'Test User',
...   'email' => 'test@example.com',
...   'password' => bcrypt('password')
... ]);
```

```bash
Use Laravel Sanctum for authentication:

1. Send POST /login with email and password or create a token manually. Token in created manually in this project to test.

2. Include the token in the header:
    Authorization: Bearer {token}
```

## 🔁 API Endpoints

```bash
| Method | Endpoint                            | Description                   |
| ------ | ----------------------------------- | ----------------------------- |
| GET    | `/api/translations`                 | Search/list translations      |
| POST   | `/api/translations`                 | Create new translation        |
| PUT    | `/api/translations/{id}`            | Update a translation          |
| GET    | `/api/translations/export/{locale}` | Export translations by locale |
```

## 📦 JSON Export Format

```bash
{
  "welcome": "Welcome",
  "logout": "Log out",
  "submit": "Submit"
}
```

## 🧪 Run Tests

```bash
php artisan test
```

## 🧠 Design Choices

```bash
This project follows best practices in Laravel and API design:

**Database Structure**
A single translations table keeps the schema simple and efficient.

Composite unique key (key, locale) prevents duplicate entries across languages.

tags is stored as a json column to support flexible contextual filtering.

Fulltext index on value enables efficient content-based search.

**Code Organization**
Controllers are kept slim by offloading validation to Form Request classes.

Eloquent ORM is used directly for simplicity and readability.

Business logic like caching and large dataset seeding is separated into dedicated files.

**Performance**
Caching is implemented in the export endpoint using Cache::remember() to reduce DB load.

db:seed-large command uses Laravel Factories to benchmark and simulate real-world load (100k+ records).

Paginated results (in /translations) prevent large payloads and memory overuse.

**Security**
Laravel Sanctum secures all endpoints with token-based authentication.

Only validated fields (key, locale, value, tags) are accepted through the API.

Logging is added in store() and update() for audit/debug support.

**Dev Standards**
Code follows PSR-12 standards.

The architecture follows SOLID principles, using separation of concerns and single-responsibility methods.
```




