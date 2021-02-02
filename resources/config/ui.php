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

        /**
         * The active theme.
         */
        'theme' => env('STREAMS_CP_THEME', 'default'),
    ],

    'inputs' => [
        'text' => \Streams\Ui\Input\Input::class,
        'hash' => \Streams\Ui\Input\Input::class, // Default
        'input' => \Streams\Ui\Input\Input::class,
        'string' => \Streams\Ui\Input\Input::class, // Default

        'date' => \Streams\Ui\Input\Date::class,
        'time' => \Streams\Ui\Input\Time::class,
        'datetime' => \Streams\Ui\Input\Datetime::class,

        'slug' => \Streams\Ui\Input\Slug::class,

        'color' => \Streams\Ui\Input\Color::class,
        'radio' => \Streams\Ui\Input\Radio::class,
        'range' => \Streams\Ui\Input\Range::class,

        'select' => \Streams\Ui\Input\Select::class,

        'integer' => \Streams\Ui\Input\Integer::class,
        'decimal' => \Streams\Ui\Input\Decimal::class,

        'textarea' => \Streams\Ui\Input\Textarea::class,
        'markdown' => \Streams\Ui\Input\Markdown::class,

        'file' => \Streams\Ui\Input\File::class,
        'image' => \Streams\Ui\Input\Image::class,

        'relationship' => \Streams\Ui\Input\Relationship::class,

        'toggle' => \Streams\Ui\Input\Toggle::class,
        'boolean' => \Streams\Ui\Input\Toggle::class, // Default
    ],
];
