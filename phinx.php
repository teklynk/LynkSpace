<?php

require_once(__DIR__ . '/htdocs/config/dbconn.php');

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/migration',
        ],
        'environments' =>
            [
                'default_database' => '*** CHOOSE AN ENVIRONMENT ***',
                'default_migration_table' => 'phinxlog',
                'development' =>
                    [
                        'adapter' => 'mysql',
                        'host' => db_servername,
                        'name' => db_name,
                        'user' => db_username,
                        'pass' => db_password,
                        'port' => 3306,
                        'charset' => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                    ],
                'staging' =>
                    [
                        'adapter' => 'mysql',
                        'host' => db_servername,
                        'name' => db_name,
                        'user' => db_username,
                        'pass' => db_password,
                        'port' => 3306,
                        'charset' => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                    ],
                'production' =>
                    [
                        'adapter' => 'mysql',
                        'host' => db_servername,
                        'name' => db_name,
                        'user' => db_username,
                        'pass' => db_password,
                        'port' => 3306,
                        'charset' => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                    ],
            ],
    ];
?>
