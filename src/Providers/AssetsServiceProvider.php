<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Providers;
use Chocofamilyme\LaravelClickHouse\Migrations\Console\ClickHouseFresh;
use Chocofamilyme\LaravelClickHouse\Migrations\Console\ClickHouseMigrate;
use Chocofamilyme\LaravelClickHouse\Migrations\Console\ClickHouseRollback;
use Illuminate\Support\ServiceProvider;

final class AssetsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClickHouseMigrate::class,
                ClickHouseRollback::class,
                ClickHouseFresh::class,
            ]);
        }
        $this->publishes([
            __DIR__."/../../config/clickhouse.php" => config_path('clickhouse.php'),
            __DIR__."/../../stubs" => base_path('stubs'),
        ], 'clickhouse');
    }
}