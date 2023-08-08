# Banking System
A banking system with two types of users: Individual and Business. The system supports deposit and withdrawal operations for both types of users.

## Setup project

```sh
# Setting up laravel project
cp .env.example .env
composer update

# Generate app key
php artisan key:generate

# Database migration
php artisan migrate

# Finally serve
php artisan serve
```
