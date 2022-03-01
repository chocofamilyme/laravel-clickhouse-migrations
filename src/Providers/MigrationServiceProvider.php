<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Providers;

use App\Infrastructure\ClickHouse\ClickHouseMigrationRepository;
use App\Infrastructure\ClickHouse\Migrator;
use ClickHouseDB\Client;
use Illuminate\Contracts\Support\DeferrableProvider;

final class MigrationServiceProvider extends \Illuminate\Database\MigrationServiceProvider implements DeferrableProvider
{
    protected function registerRepository()
    {
        $this->app->singleton('migration.repository', function ($app) {
            $table = $app['config']['database.migrations'];

            return new ClickHouseMigrationRepository(app(Client::class), $table);
        });
    }

    public function registerMigrator()
    {
        $this->app->singleton('migrator', function ($app) {
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['db'], $app['files'], $app['events']);
        });
    }
}
