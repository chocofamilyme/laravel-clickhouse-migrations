<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations;

use ClickHouseDB\Client;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;

final class ClickHouseMigrationRepository implements MigrationRepositoryInterface
{
    public function __construct(private Client $client, private string $table)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getRan(): array
    {
        $ranMigrations = $this->client->select('SELECT migration FROM migrations')->rows();

        return collect($ranMigrations)->pluck('migration')->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrations($steps): array
    {
        return $this->client->select("
            SELECT migration, batch FROM migrations
            WHERE batch >= 1
            ORDER BY batch, migration DESC
            LIMIT $steps
        ")->rows();
    }

    /**
     * {@inheritdoc}
     */
    public function getLast(): array
    {
        $bindings = ['lastBatch' => $this->getLastBatchNumber()];

        return $this->client->select('
            SELECT migration, batch FROM migrations
            WHERE batch = :lastBatch
            ORDER BY migration DESC
        ', $bindings)->rows();
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrationBatches()
    {
        // TODO: Implement getMigrationBatches() method.
    }

    /**
     * {@inheritdoc}
     */
    public function log($file, $batch)
    {
        $this->client->insert(
            'migrations',
            [
                [$file, $batch],
            ],
            ['migration', 'batch'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete($migration)
    {
        $this->client->write('ALTER TABLE migrations DELETE WHERE migration = :migration', [
            'migration' => $migration->migration,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getNextBatchNumber(): int
    {
        return $this->getLastBatchNumber() + 1;
    }

    protected function getLastBatchNumber(): int
    {
        return $this->client->select('SELECT MAX(batch) AS max FROM migrations')->fetchRow()['max'];
    }

    /**
     * {@inheritdoc}
     */
    public function createRepository()
    {
        $this->client->write("
            CREATE TABLE IF NOT EXISTS $this->table (
                migration String,
                batch Int32
            )
            ENGINE = MergeTree()
            ORDER BY batch
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function repositoryExists(): bool
    {
        return in_array($this->table, array_keys($this->client->showTables()));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRepository()
    {
        $this->client->write("DROP TABLE IF EXISTS $this->table");
    }

    /**
     * {@inheritdoc}
     */
    public function setSource($name)
    {
        // TODO: Implement setSource() method.
    }
}
