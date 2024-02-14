<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "gd", "imagick", and "gmagick" drivers.
    | You may choose one of them according to your PHP extensions.
    |
    | Supported: "gd", "imagick", "gmagick"
    |
    */

    'driver' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Image Cache Path
    |--------------------------------------------------------------------------
    |
    | The disk and the path where the processed images will be cached.
    |
    */

    'cache' => [
        'path' => storage_path('app/public/images/cache'),
        'lifetime' => 86400, // 24 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Cache Route
    |--------------------------------------------------------------------------
    |
    | The URL route used to access the image cache. You may set this to any
    | path you like, but it must match the URL that you use in your routes.
    |
    */

    'cache_route' => 'imagecache',

    /*
    |--------------------------------------------------------------------------
    | Image Cache Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware applied to the image cache route. You may change this
    | to a middleware appropriate for your application.
    |
    */

    'cache_middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Image Cache Response Headers
    |--------------------------------------------------------------------------
    |
    | The response headers applied to the image cache response. You may
    | customize these headers according to your application's needs.
    |
    */

    'cache_headers' => [
        'Cache-Control' => 'public,max-age=86400',
        'Expires' => 'public,max-age=86400',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Cache Templates
    |--------------------------------------------------------------------------
    |
    | The image cache templates define the different variations of images
    | that can be generated using the Intervention Image package.
    |
    */

    'templates' => [
        'thumbnail' => [
            'width' => 100,
            'height' => 100,
        ],
        'medium' => [
            'width' => 300,
            'height' => 300,
        ],
        'large' => [
            'width' => 800,
            'height' => 800,
        ],
    ],

];
