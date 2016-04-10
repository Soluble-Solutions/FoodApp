<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'dbConn'=>[
          'username'=>'admin',
          'password'=>'tester123',
          'host'=>'localhost',
          'dbname'=>'foodapp',
          'db'=>'mysql',
          'displayErrorDetails' => true,
        ],
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
];
