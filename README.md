# Laravel ClickHouse migrations

## Instalation:
- `composer require chocofamilyme/laravel-clickhouse-migrations`
- Comment out `Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class` in config/app.php
- Add `Chocofamilyme\LaravelClickHouse\Migrations\Providers\ConsoleSupportServiceProvider::class` to config/app.php


## Commands:
- create migrations: as usual `php artisan make:migration migration_name`
- migrate: `php arisan clickhouse:migrate {--step} {--force : Force the operation to run when in production}`
- rollback: `php arisan clickhouse:migrate:rollback {--step} {--force : Force the operation to run when in production}`
- fresh: `php artisan clickhouse:migrate:fresh`
