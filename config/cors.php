<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/*'], // Add storage path
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Use specific origins if needed for security
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];