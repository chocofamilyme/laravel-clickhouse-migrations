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
            'host' => config('clickhouse.host', 'localhost'),
            'port' => config('clickhouse.port', '8123'),
            'username' => config('clickhouse.username', 'username'),
            'password' => config('clickhouse.password', ''),
        ]))->database(config('clickhouse.database', 'laravel'));

        $client->setTimeout(config('clickhouse.options.timeout', 10));
        $client->setConnectTimeOut(config('clickhouse.options.connect_timeout', 10));

        $this->app->instance(Client::class, $client);
    }
}
