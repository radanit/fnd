<?php

return [

    /**
     * Storage Adapters
     * The storage adapter
     */
    'storage' => [
        'enabled' => true,
        'driver' => 'elequent', // elequent, redis, file, pdo, custom
        'path' => storage_path('app/runtime.json'), // For file driver
        'connection' => null, // leave null for default connection
        'provider' => App\Radan\Config\Models\Config::class, // instance of StorageInterface
        // App\Radan\Config\Adapters\Db::class,
    ],

    /**
     * The list of modifiers you want to allow into your Config instance
     */
    'modifiers' => [
        App\Radan\Config\Modifiers\Json::class,
        App\Radan\Config\Modifiers\Boolean::class,
    ]
];
