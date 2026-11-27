<?php

return [
    'access_mode' => env('ADMIN_ACCESS_MODE', 'institutional'),
    'restrict_network' => env('ADMIN_RESTRICT_NETWORK', false),
    'allowed_networks' => array_values(array_filter(array_map('trim', explode(',', (string) env('ADMIN_ALLOWED_NETWORKS', ''))))),
    'superadmin' => [
        'name' => env('SUPERADMIN_NAME'),
        'email' => env('SUPERADMIN_EMAIL'),
        'password' => env('SUPERADMIN_PASSWORD'),
    ],
];
