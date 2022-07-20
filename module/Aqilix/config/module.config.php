<?php

return [
    "service_manager" => [
        "invokables" => [
            "oauth2.accessToken" => \Aqilix\OAuth2\ResponseType\AccessToken::class
        ],
        "factories"  => [
            "Aqilix\Service\Mail" => \Aqilix\Service\Mail\MailgunAppFactory::class,
            \Aqilix\Service\ProcessBuilder::class => \Aqilix\Service\ProcessBuilderFactory::class,
        ],
        "abstract_factories" => [
            \Aqilix\OAuth2\Mapper\MapperFactory::class,
            \Laminas\Log\LoggerAbstractServiceFactory::class,
        ],
        "delegators" => [
            "logger_default" => [
                Aqilix\Service\PsrLoggerDelegator::class
            ]
        ]
    ],
    "log" => [
        "logger_default" => [
            "writers" => [
                [
                    "name" => "stream",
                    "priority" => \Laminas\Log\Logger::DEBUG,
                    "options" => [
                        'stream' => 'data/log/system.log',
                    ]
                ]
            ]
        ]
    ]
];
