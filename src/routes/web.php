<?php

use App\Http\Controllers\AddressController;

return [
    'GET' => [
        '/' => ['controller' => AddressController::class, 'action' => 'index'],
        '/address' => ['controller' => AddressController::class, 'action' => 'store'],
    ],
    'POST' => [
        '/address' => ['controller' => AddressController::class, 'action' => 'store'],
    ],
    'DELETE' => [
        '/address' => ['controller' => AddressController::class, 'action' => 'destroy'],
    ]
];