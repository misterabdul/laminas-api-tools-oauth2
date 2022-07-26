<?php

return [
    'project' => [
        'sites' => [
            'reset_password_url'    => 'https://example.com/user/resetpassword/:code',
            'activation_url'        => 'https://example.com/user/activation/:code',
            'contact_us'            => 'https://example.com'
        ],
        'php_process' => [
            'php_binary'    => '/usr/bin/php',
            'script'        => __DIR__ . '/../../vendor/bin/laminas',
        ],
    ],
];
