<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],

    'allowed_origins' => [env('APP_URL', 'http://localhost'), env('FRONTEND_URL', 'http://localhost:5173')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With', 'X-XSRF-TOKEN', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 86400,

    'supports_credentials' => true,

];
