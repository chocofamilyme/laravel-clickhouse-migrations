<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Providers;

use Illuminate\Support\AggregateServiceProvider;

final class ClickHouseMigrationsServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        AssetsServiceProvider::class,
        ClickHouseProvider::class,
        ConsoleSupportServiceProvider::class,
    ];
}
