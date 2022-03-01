<?php

declare(strict_types=1);

namespace Chocofamilyme\LaravelClickHouse\Migrations;

use ClickHouseDB\Client;
use Illuminate\Database\Migrations\Migration;

abstract class AbstractMigration extends Migration
{
    public function getConnection()
    {
        return app(Client::class);
    }
}
