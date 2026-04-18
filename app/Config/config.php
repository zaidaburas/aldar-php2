<?php

return [
    'app' => [
        'name' => 'مطاعم الدار - لوحة التحكم',
        'url' => 'http://localhost:8080',
        'env' => 'local',
        'debug' => true,
    ],
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'aldar_restaurant',
        'charset' => 'utf8mb4',
        'username' => 'user1',
        'password' => '12345',
    ],
    'security' => [
        'session_key' => 'admin_user',
        'csrf_key' => '_csrf_token',
    ],
    'uploads' => [
        'base_path' => BASE_PATH . '/public/storage/uploads',
        'base_url' => '/storage/uploads',
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
        'max_size' => 5 * 1024 * 1024,
    ],
];
