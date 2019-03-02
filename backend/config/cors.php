<?php

return [
    'allowedOrigins'=> env("CORS_ALLOWED_ORIGINS", '*'),
    'exposedHeaders'=> env('CORS_EXPOSED_HEADERS', '[X-My-Custom-Header, X-Another-Custom-Header]'),
    'maxAge'=> env('CORS_MAX_AGE', 86400),
    'allowedMethods'=> env('CORS_ALLOWED_METHODS', '[POST, GET, OPTIONS]'),
    'allowedHeaders'=> env('CORS_ALLOWED_HEADERS', '[X-PINGOTHER, Content-Type]'),
    'allowCredentials' => env('CORS_ALLOW_CREDENTIALS', false),
];
