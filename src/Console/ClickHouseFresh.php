<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations\Console;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;

final class ClickHouseFresh extends FreshCommand
{
    private MigrationRepositoryInterface $migrationRepository;
    protected $signature = 'clickhouse:migrate:fresh';

    public function __construct()
    {
        parent::__construct();
        $this->migrationRepository = app('migration.repository');
    }

    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $this->call('clickhouse:migrate:rollback', [
            '--step' => $this->migrationRepository->getNextBatchNumber() - 1,
            '--force' => true,
        ]);

        $this->call('clickhouse:migrate', [
            '--force' => true,
        ]);

        if ($this->laravel->bound(Dispatcher::class)) {
            $this->laravel[Dispatcher::class]->dispatch(
                new DatabaseRefreshed
            );
        }

        return 0;
    }
}
