<?php

return [
    'ty' => [
        'client_id' => env('TY_CLIENT_ID'),
        'secret' => env('TY_SECRET'),
        'schema' => env('TY_SCHEMA'),
        'api' => env('TY_API', 'https://openapi.tuyacn.com')
    ],
    'ys' => [
        'key' => env('YS_KEY'),
        'secret' => env('YS_SECRET'),
        'api' => env('YS_API', 'https://open.ys7.com')
    ]
];