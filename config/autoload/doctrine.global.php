<?php

return [
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'table_storage' => [
                    'table_name'                    => 'migrations',
                    'version_column_name'           => 'version',
                    'version_column_length'         => 1024,
                    'executed_at_column_name'       => 'executed_at',
                    'execution_time_column_name'    => 'execution_time',
                ],
                'migrations_paths' => [
                    'DoctrineORMModule\Migrations' => 'data/DoctrineORMModule/Migrations',
                ],
            ],
        ],
    ],
];
