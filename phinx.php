<?php

//env on
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

return [
     'paths' => [
         'migrations' => 'application/migrations',
     ],
     'environments' => [
         'default_migration_table' => 'phinxlog',
         'default_database'        => 'development',
         'development'             => [
             'adapter' => 'mysql',
             'host' => getenv('DB_HOST'),
             'user' => getenv('DB_USERNAME'),
             'pass' => getenv('DB_PASSWORD'),
             'name' => getenv('DB_DATABASE'),
             'port'    => '3306',
             'charset' => 'utf8',
         ],
     ],
 ];