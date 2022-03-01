<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations;

use Illuminate\Database\Events\MigrationEnded;
use Illuminate\Database\Events\MigrationStarted;

final class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    public function run($paths = [], array $options = [])
    {
        $files = $this->getMigrationFiles($paths);

        $this->requireFiles($migrations = $this->pendingMigrations(
            $files,
            $this->repository->getRan()
        ));

        $this->runPending($migrations, $options);

        return $migrations;
    }

    protected function runMigration($migration, $method)
    {
        if (method_exists($migration, $method)) {
            $this->fireMigrationEvent(new MigrationStarted($migration, $method));

            $migration->{$method}();

            $this->fireMigrationEvent(new MigrationEnded($migration, $method));
        }
    }
}
