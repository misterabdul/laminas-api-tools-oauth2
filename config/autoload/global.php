<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'dummy' => [],
        ],
    ],
    'laminas-mvc-auth' => [
        'authentication' => [
            'adapters' => [
                'oauth2_pdo' => [
                    'adapter' => '',
                    'storage' => [],
                ],
            ],
            'map' => [
                'User\\V1' => 'oauth2_pdo',
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'oauth' => [
                'options' => [
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ],
                'type' => 'regex',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'User\\V1' => 'oauth2_pdo',
            ],
        ],
    ],
];
