# Installation

Prereqs
- PHP 8.1+ (project targets PHP 8.2)
- Composer
- MySQL/MariaDB
- Git

1) Clone

```bash
git clone <your-repo-url> credentials
cd credentials
```

2) Install PHP dependencies

This repository uses `app-core/composer.json`.

```bash
cd app-core
composer install --no-dev --prefer-dist
```

3) Copy environment file

Create an `.env` in `app-core` (or copy `env` provided by CodeIgniter) and set at minimum:

- `database.default.hostname`
- `database.default.database`
- `database.default.username`
- `database.default.password`
- `app.baseURL`

Example (partial) `.env` values:

```
app.baseURL = 'http://localhost:8091'
database.default.hostname = localhost
database.default.database = credentials
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

4) Create the database and import schema (option A) or run migrations (option B)

Option A — Import provided SQL schema

```bash
mysql -u root -p
CREATE DATABASE credentials CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT
mysql -u root -p credentials < db/credentials.sql
```

Option B — Migrations + Seeders (preferred for dev)

```bash
cd app-core
php spark migrate
php spark db:seed DatabaseSeeder
```

5) Ensure writable directories exist

From `app-core`:

```bash
mkdir -p writable/cache writable/logs writable/session writable/uploads
chmod -R 0777 writable
```

6) Start local server

From `app-core`:

```bash
php -S 127.0.0.1:8091 index.php
```

Or use CodeIgniter's spark serve:

```bash
php spark serve --host=127.0.0.1 --port=8091
```

7) Login

Seeders include a `super_admin` account for development. Check `app/Database/Seeds/UserSeeder.php` for the seeded username and password.
