<?php


use Illuminate\Support\Facades\Hash;

return [

    /*
    |--------------------------------------------------------------------------
    | Default admin user
    |--------------------------------------------------------------------------
    |
    | Default user will be created at project installation/deployment
    |
    */

    'admin_name' => env('ADMIN_NAME', 'admin'),
    'admin_email' => env('ADMIN_EMAIL', 'admin@admin.com'),
    'admin_password' => env('ADMIN_PASSWORD', '123456'),
];
