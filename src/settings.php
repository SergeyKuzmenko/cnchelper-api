<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => true, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'api',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/api.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'host' => 'localhost',
            'db' => 'api',
            'user' => 'user',
            'pass' => 'pass'
        ]
    ],
];