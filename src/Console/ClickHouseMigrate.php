<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Console;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\MigrateCommand;

final class ClickHouseMigrate extends MigrateCommand
{
    protected $signature = 'clickhouse:migrate {--step} {--force : Force the operation to run when in production}';

    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct(app('migrator'), $dispatcher);
    }

    protected function prepareDatabase()
    {
        if (! $this->migrator->repositoryExists()) {
            $this->call('migrate:install');
        }
    }

    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }
        $this->prepareDatabase();

        $this->migrator->setOutput($this->output)
            ->run($this->getMigrationPaths(), [
                'step' => $this->option('step'),
            ]);

        return 0;
    }
}
