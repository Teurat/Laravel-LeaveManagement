# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Start all dev services (Laravel server, Vite, queue worker, log viewer)
composer run dev

# Individual services
php artisan serve       # Laravel on localhost:8000
npm run dev             # Vite asset compilation with HMR

# Run all tests
composer run test
php artisan test

# Run a single test
php artisan test --filter TestName

# Database
php artisan migrate
php artisan migrate:refresh   # Rollback all and re-run

# Production assets
npm run build
```

## Architecture

**Stack:** Laravel 12 (PHP 8.2+), Blade + Tailwind CSS v3 + Alpine.js, MySQL, Pest testing

**Layers:**
- `app/Models/` — Eloquent models with relationships and attribute casting
- `app/Http/Controllers/` — Resource controllers handling both validation and business logic (no separate service layer)
- `resources/views/` — Blade templates organized by resource (`companies/`, `employees/`, `leaves/`, `leavetypes/`)
- `routes/web.php` — All application routes; `routes/auth.php` — Breeze auth routes

**Data model:**
- `Company` → hasMany `Employee` → hasMany `Leave` → belongsTo `LeaveType`
- All FK constraints have cascade delete
- `Employee.AnnualLeaveDays` = 29 (base) + years employed since `EmployedInCompany`
- `Employee.LeaveDaysLeft` is recalculated on every leave create/update/delete via `LeaveController::updateEmployeeLeaveDaysLeft()`

**Business logic to be aware of:**
- Annual leave days formula (29 + tenure years) is hardcoded in `EmployeeController`
- Leave approval/deletion triggers balance recalculation for the affected employee
- The string `"Annual Leave"` is hardcoded in controllers as a special leave type name
- All four main resources (`Company`, `Employee`, `LeaveType`, `Leave`) support CSV bulk import via POST `/resource/import` — CSV parsing skips index 0 (header row)

**Authentication:** Laravel Breeze (email + password, standard session-based)

**Test setup:** Pest with `RefreshDatabase` trait; tests run against SQLite `:memory:` regardless of `.env` database (configured in `phpunit.xml`)
