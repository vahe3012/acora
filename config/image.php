<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'sizes' => [
        'xl' => ['width' => 871, 'height' => 335],
        'l' => ['width' => 628, 'height' => 306],
        'm' => ['width' => 564, 'height' => 395],
        's' => ['width' => 187, 'height' => 170],
        'xs' => ['width' => 140, 'height' => 140]
    ]
];
