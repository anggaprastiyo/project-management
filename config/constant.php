<?php

return [
    'default_role_id' => 2,
    'sync_user' => [
        'url' => env('SYNC_API_USER_URL'),
        'username' => env('SYNC_API_USER_USERNAME'),
        'password' => env('SYNC_API_USER_PASSWORD'),
    ],
];
