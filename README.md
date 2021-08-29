# Localiser

A self-hosting localization tool.

## Requirements

- PHP ^7.3

## Usage

### Fetch cached locales

`GET` `/api/project/:id/locales`

### Delete cached locales

`DELETE` `/api/project/:id/locales`

### Fetch cached translations

`GET` `/api/project/:id/messages`

### Delete cached translations

`DELETE` `/api/project/:id/messages`

## Version Control

Download locale files to project with [Localiser CLI](https://github.com/memochou1993/localiser-cli) easily.

## Roles

### System Scope

| Ability          |       Admin        |        User        |
| ---------------- |:------------------:|:------------------:|
| `USER_VIEW`      | :heavy_check_mark: | :heavy_check_mark: |
| `USER_CREATE`    | :heavy_check_mark: |                    |
| `USER_UPDATE`    | :heavy_check_mark: |                    |
| `USER_DELETE`    | :heavy_check_mark: |                    |
| `PROJECT_VIEW`   | :heavy_check_mark: | :heavy_check_mark: |
| `PROJECT_CREATE` | :heavy_check_mark: | :heavy_check_mark: |

### Project Scope

| Ability           |       Owner        |     Maintainer     |      Reporter      | Guest |
| ----------------- |:------------------:|:------------------:|:------------------:|:-----:|
| `PROJECT_UPDATE`  | :heavy_check_mark: | :heavy_check_mark: |                    |       |
| `PROJECT_DELETE`  | :heavy_check_mark: |                    |                    |       |
| `LANGUAGE_CREATE` | :heavy_check_mark: |                    |                    |       |
| `LANGUAGE_UPDATE` | :heavy_check_mark: | :heavy_check_mark: |                    |       |
| `LANGUAGE_DELETE` | :heavy_check_mark: |                    |                    |       |
| `KEY_CREATE`      | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |       |
| `KEY_UPDATE`      | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |       |
| `KEY_DELETE`      | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |       |
| `VALUE_CREATE`    | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |       |
| `VALUE_UPDATE`    | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |       |
| `VALUE_DELETE`    | :heavy_check_mark: | :heavy_check_mark: | :heavy_check_mark: |       |

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
