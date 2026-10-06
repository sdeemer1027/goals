# Goals

A Laravel-based web application for managing and tracking goals.

## Project Status

**Development Stage:** Initial Setup
**Database:** `goals`
**Database Migration Status:** Not yet migrated
**GitHub Repository:** `sdeemer1027/goals`

---

# Technology Stack

## Application

| Component         | Installed Version |
| ----------------- | ----------------: |
| Laravel Framework |           13.35.0 |
| PHP               |            8.3.33 |
| Composer          |            2.10.3 |
| MySQL             |   Database server |
| Vue               |            3.5.43 |
| Inertia.js Vue 3  |            2.3.28 |
| Bootstrap         |             5.3.8 |
| jQuery            |             4.0.0 |
| Axios             |            1.20.0 |

## Front-End / Build Tools

| Component           | Installed Version |
| ------------------- | ----------------: |
| Node.js             |           24.21.0 |
| npm                 |           11.19.0 |
| Vite                |             8.3.3 |
| Laravel Vite Plugin |             3.2.0 |
| Vue Vite Plugin     |             6.0.9 |
| Tailwind CSS        |            3.4.19 |
| Tailwind CSS Vite   |             4.3.3 |
| Tailwind CSS Forms  |            0.5.11 |
| PostCSS             |            8.5.29 |
| Autoprefixer        |            10.6.1 |
| Concurrently        |             9.2.1 |

## UI / Additional Packages

| Package      | Version |
| ------------ | ------: |
| Font Awesome |   7.3.1 |

## Development Tools

| Tool |          Version |
| ---- | ---------------: |
| Git  | 2.45.1.windows.1 |

---

# Server Requirements

The development environment requires:

* PHP 8.3+
* Laravel 13.x
* Composer 2.x
* MySQL
* Node.js
* npm
* Git
* A web server or Laravel's development server

## PHP

The current development environment uses:

```text
PHP 8.3.33
```

Laravel's required PHP extensions must also be enabled.

---

# Development Environment

## Operating System

Windows.

## Project Location

```text
D:\lara\steve\laravel
```

## PHP Environment

The current PHP CLI executable is:

```text
D:\wamp64\bin\php\php8.3\php.exe
```

## Database

```text
Database Name: goals
Database Engine: MySQL
Migration Status: Not yet migrated
```

The MySQL command-line client is not currently available through the Windows PATH.

This does not prevent Laravel from connecting to the MySQL server. Laravel will connect using the database settings configured in the `.env` file.

---

# Installation

Clone the repository:

```bash
git clone https://github.com/sdeemer1027/goals.git
cd goals
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create the environment file:

```bash
copy .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=goals
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run database migrations:

```bash
php artisan migrate
```

> Database migrations have not yet been executed in the current development environment.

---

# Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

In a second terminal, start Vite:

```bash
npm run dev
```

Use the URL displayed by Laravel's development server to access the application.

---

# Production Build

Build the front-end assets with:

```bash
npm run build
```

---

# Git / GitHub

The project uses Git for source control.

## Repository

```text
https://github.com/sdeemer1027/goals
```

## Main Branch

```text
main
```

## Typical Git Workflow

Check the current status:

```bash
git status
```

Stage changes:

```bash
git add .
```

Commit changes:

```bash
git commit -m "Description of changes"
```

Push changes:

```bash
git push origin main
```

---

# Project Architecture

The current application uses:

* Laravel 13
* Inertia.js
* Vue 3
* Vite
* Bootstrap 5

## JavaScript Structure

```text
resources/
└── js/
    ├── app.js
    ├── bootstrap.js
    ├── Components/
    ├── Layouts/
    └── Pages/
```

---

# Development Rules

This application is being developed incrementally.

Each development task should:

1. Have a defined task number.
2. Identify the files being created or modified.
3. Provide complete code when a file needs to be replaced.
4. Be tested before moving to the next task.
5. Be confirmed as completed before being considered finished.

The project manager will confirm completion of each task.

---

# Project Roadmap

## Phase 1 — Foundation

* [x] Laravel project created
* [x] Git initialized
* [x] GitHub repository created
* [x] MySQL `goals` database created
* [x] Laravel version documented
* [x] PHP version documented
* [x] Composer version documented
* [x] Node.js version documented
* [x] npm version documented
* [x] Git version documented
* [x] Front-end package versions documented
* [ ] Database connection configured
* [ ] Initial migrations
* [ ] Base application layout
* [ ] Authentication
* [ ] User system

## Phase 2 — Core Goals

* [ ] Goal data model
* [ ] Goal creation
* [ ] Goal editing
* [ ] Goal completion
* [ ] Goal status tracking
* [ ] Goal categories
* [ ] Goal dashboard

## Phase 3 — User Experience

* [ ] Responsive design
* [ ] Navigation
* [ ] Dashboard improvements
* [ ] Goal progress visualization
* [ ] Notifications
* [ ] Mobile optimization

## Phase 4 — Testing & Deployment

* [ ] Application testing
* [ ] Database testing
* [ ] Security review
* [ ] Production configuration
* [ ] Production deployment
* [ ] Final documentation

---

# Project Notes

This README is a living document.

It should be updated as the application architecture, features, database structure, and deployment process develop.

---

## Current Development Baseline

```text
Laravel       13.35.0
PHP           8.3.33
Composer      2.10.3
Node.js       24.21.0
npm           11.19.0
Vue           3.5.43
Inertia       2.3.28
Bootstrap     5.3.8
Vite          8.3.3
Git           2.45.1.windows.1
Database      goals
```
