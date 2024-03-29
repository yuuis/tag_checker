<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

//     'connections' => [
//         'mysql' => [
//             'driver' => 'mysql',
//             'read' => [
//                 'host' => '127.0.0.1',
//             ],
//             'write' => [
//                 'host' => '127.0.0.1'
//             ],
//             'port' => '3306',
//             'database' => 'abtool',
//             'username' => 'root',
//             'password' => 'password',
//             'unix_socket' => '',
//             'charset' => 'utf8mb4',
//             'collation' => 'utf8mb4_unicode_ci',
//             'prefix' => '',
//             'strict' => true,
//             'engine' => null,
//             'options'   => array(
//                 PDO::ATTR_PERSISTENT => true,
//             ),
//         ],
//     ],

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'Advertisement',
            'username' => 'root',
            'password' => 'password',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'options'   => array(
                PDO::ATTR_PERSISTENT => true,
            ),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',


];
