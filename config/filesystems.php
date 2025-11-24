<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        //cambiarlo cuando se suba al servidor
        'uploads' => [
            'driver' => 'local',
            'root' => public_path('static/img/upload'), // Utiliza la función public_path para obtener la ruta absoluta a la carpeta public
        ],
        
        'uploads_user' => [
            'driver' => 'local',
            'root' => public_path('static/img/uploads_user'), // Utiliza la función public_path para obtener la ruta absoluta a la carpeta public
        ],

        'uploads_product' => [
            'driver' => 'local',
            'root' => public_path('storage/img/uploads_product'), 
            'url' => env('APP_URL').'storage/img/uploads_product',
            'visibility' => 'public',
        ],

        'uploads_product_image' => [
            'driver' => 'local',
            'root' => public_path('storage/img/uploads_product_image'), 
            'url' => env('APP_URL').'storage/img/uploads_product_imge',
            'visibility' => 'public',
        ],

        'uploads_video_home' => [
            'driver' => 'local',
            'root' => public_path('storage/video/uploads_video_home'), 
            'url' => env('APP_URL').'storage/video/uploads_video_home',
            'visibility' => 'public',
        ],

        'public' => [
            'driver' => 'local',
            'root' => public_path('static/uploads_product'),
            'url' => env('APP_URL').'/static/uploads_product',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
