<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Providers;

use ClickHouseDB\Client;
use Illuminate\Support\ServiceProvider;

final class ClickHouseProvider extends ServiceProvider
{
    public function register(): void
    {
        $client = (new Client([
            'host' => config('database.connections.clickhouse.host'),
            'port' => config('database.connections.clickhouse.port'),
            'username' => config('database.connections.clickhouse.username'),
            'password' => config('database.connections.clickhouse.password'),
        ]))->database(config('database.connections.clickhouse.options.database'));

        $client->setTimeout(config('database.connections.clickhouse.options.timeout'));
        $client->setConnectTimeOut(config('database.connections.clickhouse.options.connectTimeOut'));

        $this->app->instance(Client::class, $client);
    }
}
