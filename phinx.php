<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';


if(file_exists(__DIR__ .'/.env')) {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->overload();
}

$db = include __DIR__ . '/config/db.php';

list(
    'driver' => $adapter,
    'host' => $host,
    'database' => $name,
    'username' => $user, 
    'password' => $pass,
    'charset' => $charset,
    'collation' => $collation
    // Selecionar o banco que está sendo usado ou de desenvolvimento ou de produção
) = $db['default_connection']; 

return [
    'paths' => [
        'migrations' => [
            __DIR__ . '/db/migrations'
        ],
        'seeds' => [
            __DIR__ .'/db/seeds'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'dafault_database' => 'default_connection', // Selecionar banco ( produção ou desenvolvimento )
    /*  'development' => [
            'adapter' => $adapter,
            'host' => $host,
            'name' => $name,
            'user' => $user,
            'pass' => $pass,
            'charset' => $charset,
            'collation' => $collation
        ] */
        'default_connection' => [
            'adapter' => $adapter,
            'host' => $host,
            'name' => $name,
            'user' => $user,
            'pass' => $pass,
            'charset' => $charset,
            'collation' => $collation
        ]
    ]
];