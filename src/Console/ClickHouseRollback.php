<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Console;

use Illuminate\Database\Console\Migrations\RollbackCommand;

final class ClickHouseRollback extends RollbackCommand
{
    protected $signature = 'clickhouse:migrate:rollback {--step} {--force : Force the operation to run when in production}';

    public function __construct()
    {
        parent::__construct(app('migrator'));
    }

    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $this->migrator->setOutput($this->output)->rollback(
            $this->getMigrationPaths(),
            [
                '--step' => $this->option('step'),
            ]
        );

        return 0;
    }
}
