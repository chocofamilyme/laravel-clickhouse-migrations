# Laravel ClickHouse migrations

## Requirements:
- php ^8.0
- Laravel ^8.2

## Currently, Laravel 9 Is not supported because of migration stub logic changes

## Installation:
- `composer require chocofamilyme/laravel-clickhouse-migrations`
- Comment out `Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class` in config/app.php
- Add Providers
```php
<?php

return [
    // Other providers
    /*
     * Package Service Providers...
    */
    Chocofamilyme\LaravelClickHouse\Migrations\Providers\AssetsServiceProvider::class,
    Chocofamilyme\LaravelClickHouse\Migrations\Providers\ClickHouseProvider::class,
    Chocofamilyme\LaravelClickHouse\Migrations\Providers\ConsoleSupportServiceProvider::class,
    // Other providers
];
```
- Publish config and stubs `php artisan vendor:publish --tag=clickhouse`
- Change configurations in config/clickhouse.php

## Commands:
- create migrations: as usual `php artisan make:migration migration_name`
- migrate: `php arisan clickhouse:migrate {--step} {--force : Force the operation to run when in production}`
- rollback: `php arisan clickhouse:migrate:rollback {--step} {--force : Force the operation to run when in production}`
- fresh: `php artisan clickhouse:migrate:fresh`
