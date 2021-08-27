# Localiser

A self-hosted localization tool.

## Requirements

- PHP ^7.3

## Development

Download the master branch.

```BASH
git clone git@github.com:memochou1993/localiser.git
```

Copy `.env.example` to `.env`.

```BASH
cp .env.example .env
```

Install the dependencies.

```BASH
composer install
```

Set a random secure application key.

```BASH
php artisan key:generate
```

Create a database.

```MYSQL
CREATE DATABASE `localiser`;
```

Run the migrations and database seeds.

```BASH
php artisan migrate --seed
```

Start a development server.

```BASH
php artisan serve
```
