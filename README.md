# Localiser

A self-hosted localization tool.

## Requirements

- PHP ^7.3

## Installation

Download the master branch.

```BASH
git clone git@github.com:memochou1993/localiser.git
```

Copy `.env.example` to `.env`.

```BASH
cp .env.example .env
```

Install the Composer dependencies.

```BASH
composer install
```

Set a random secure application key.

```BASH
php artisan key:generate
```

Run the migrations and database seeds.

```BASH
php artisan migrate --seed
```
