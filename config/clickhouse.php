<?php

return [
    'host' => env('CLICKHOUSE_HOST', 'localhost'),
    'port' => env('CLICKHOUSE_PORT', '8183'),
    'username' => env('CLICKHOUSE_USERNAME', 'user'),
    'password' => env('CLICKHOUSE_USERNAME', ''),
    'database' => env('CLICKHOUSE_DB', 'laravel'),
    'options' => [
        'timeout' => env('CLICKHOUSE_TIMEOUT', 10),
        'connect_timeout' => env('CLICKHOUSE_CONNECT_TIMEOUT', 10),
    ],
];