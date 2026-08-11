<?php

return [
    'name' => 'JobHub',
    'timezone' => 'Asia/Ho_Chi_Minh',
    'default_locale' => 'en',
    'supported_locales' => ['en', 'vi'],

    'upload_max_size' => 5 * 1024 * 1024, // 5MB in bytes
    'allowed_image_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ],
    'allowed_resume_types' => [
        'application/pdf',
    ],

    'items_per_page' => 12,
    'password_min_length' => 6,
];
