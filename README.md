# Home Services Management System

A Laravel-based web application for managing on-demand home services — connecting customers with service providers through a role-based platform with full admin oversight.

## Overview

The system supports three user roles — **Admin**, **Service Provider**, and **Customer** — each with its own dashboard and permissions. Providers offer services from a shared catalog at their own pricing, customers book those services, and admins manage users, providers, and the overall platform.

## Features

- **Role-based access control** for Admin, Provider, and Customer accounts
- **Service catalog** with categories and subcategories, shared across all providers
- **Provider-specific pricing** — providers attach their own price, duration, and availability to catalog services
- **Booking management** with full lifecycle tracking: status, payment status, and cancellations
- **Admin dashboard** for platform-wide user and service management
- **Provider dashboard** for managing offered services and incoming bookings
- **Admin user management** with full CRUD and modal-based workflows

## Tech Stack

- **Backend:** Laravel
- **Frontend:** Laravel Livewire (Volt single-file components), Blade
- **Database:** MySQL
- **Local environment:** XAMPP

## Database Schema (high-level)

| Table | Purpose |
|---|---|
| `services` | Shared catalog table — category, subcategory, service name, base price, duration, status |
| `provider_services` | Pivot table linking providers to catalog services with their own price, duration, and status |
| `bookings` | customer_id, provider_id, service_id, booking date/time, address, amount, status, payment_status, cancellation fields, completed_at |

## Installation

```bash
git clone <repository-url>
cd <project-folder>

composer install
cp .env.example .env
php artisan key:generate

# configure your database credentials in .env, then:
php artisan migrate

```bash
composer required spatie/sptie.php

npm install
npm run dev

php artisan serve
```

## Demo Accounts

For testing/review purposes, seeded accounts are available for each role:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gmail.com` | `12345678` |
| Provider | `arfa@gmail.com` | `12345678` |
| Customer | `customer@gmail.com` | `12345678` |

> Replace these with whatever your `DatabaseSeeder` actually creates. Keep real/production credentials out of the README — this table is meant for local/demo environments only.

## Roadmap

Development follows a phased build roadmap (13 phases), moving from core schema and authentication through role dashboards, booking flow, and admin tooling.

---

*Note: some sections above (installation commands, repository URL) are written with reasonable defaults — swap in your actual repo URL, PHP/Laravel version. Let me know if any of the feature or schema descriptions are off and I'll correct them.*
