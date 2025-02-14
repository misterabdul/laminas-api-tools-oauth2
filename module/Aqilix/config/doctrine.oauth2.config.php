<?php

return [
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    // pick any listeners you need
                    \Gedmo\Timestampable\TimestampableListener::class,
                    \Gedmo\SoftDeleteable\SoftDeleteableListener::class,
                ],
            ],
        ],
        'driver' => [
            'aqilix_oauth2_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\XmlDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm/oauth2']
            ],
            'orm_default' => [
                'drivers' => [
                    'Aqilix\OAuth2\Entity' => 'aqilix_oauth2_entity'
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'filters' => [
                    'soft-deleteable' => \Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter::class
                ]
            ]
        ]
    ]
];
