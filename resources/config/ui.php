<?php

return [

    'cp' => [

        /*
        |--------------------------------------------------------------------------
        | Control Panel Customization
        |--------------------------------------------------------------------------
        |
        | Support for control panel configuration is
        | currently limited to the Streams module.
        |
        */

        /**
         * This is the URI  prefix
         * for the control panel.
         */
        'prefix' => env('STREAMS_CP_PREFIX', 'cp'),

        /**
         * Define additional CP middleware.
         */
        'middleware' => [
            //\App\Http\Middleware\RickRoll::class,
        ],
    ],
];
