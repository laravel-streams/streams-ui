---
title: Configuration
category: getting_started
intro: Configuring the UI.
sort: 2
enabled: true
---

## Configuration Files

Published configuration files reside in `config/streams/`.

``` files
├── config/streams/
│   └── ui.php
```

### Publishing Configuration

Use the following command to publish configuration files.

```bash
php artisan vendor:publish --provider=Streams\\Ui\\UiServiceProvider --tag=config
```

The above command will copy configuration files from their package location to the directory mentioned above so that you can modify them directly and commit them to your version control system.

### Publishing Streams

Use the following command if you would like to publish and modify stream definitions used by this package.

```bash
php artisan vendor:publish --provider=Streams\\Ui\\UiServiceProvider --tag=streams
```

The above command will copy stream definition files from their package location to the `streams` directory so that you can modify them and commit them to your version control system.

## Configuring the UI

Below are the contents of the published configuration file:

```php
// config/streams/ui.php

return [

    /**
     * Specify whether the CP is enabled or not.
     */
    'cp_enabled' => env('STREAMS_CP_ENABLED', true),

    /**
     * This is the URI  prefix
     * for the control panel.
     */
    'cp_prefix' => env('STREAMS_CP_PREFIX', 'cp'),

    /**
     * The active theme.
     */
    'cp_theme' => env('STREAMS_CP_THEME', 'default'),

    /*
     * Specify the CP fallback policy.
     * 
     * This policy will be ran if no stream, route,
     * or component policy is otherwise specified.
     */
    'cp_policy' => env('STREAMS_CP_POLICY'),

    /*
     * Specify the CP group middleware.
     */
    'cp_middleware' => ['web', 'cp'],

    /**
     * Specify input types.
     */
    'input_types' => [
        'text' => \Streams\Ui\Input\Input::class,
        'hash' => \Streams\Ui\Input\Input::class,
        'input' => \Streams\Ui\Input\Input::class,
        'string' => \Streams\Ui\Input\Input::class,

        'date' => \Streams\Ui\Input\Date::class,
        'time' => \Streams\Ui\Input\Time::class,
        'datetime' => \Streams\Ui\Input\Datetime::class,

        'slug' => \Streams\Ui\Input\Slug::class,

        'color' => \Streams\Ui\Input\Color::class,
        'radio' => \Streams\Ui\Input\Radio::class,
        'range' => \Streams\Ui\Input\Range::class,

        'select' => \Streams\Ui\Input\Select::class,
        'checkboxes' => \Streams\Ui\Input\Checkboxes::class,
        'multiselect' => \Streams\Ui\Input\Multiselect::class,

        'integer' => \Streams\Ui\Input\Integer::class,
        'decimal' => \Streams\Ui\Input\Decimal::class,

        'textarea' => \Streams\Ui\Input\Textarea::class,
        'markdown' => \Streams\Ui\Input\Markdown::class,

        'file' => \Streams\Ui\Input\File::class,
        'image' => \Streams\Ui\Input\Image::class,

        'relationship' => \Streams\Ui\Input\Relationship::class,

        'toggle' => \Streams\Ui\Input\Toggle::class,
        'boolean' => \Streams\Ui\Input\Checkbox::class,
    ],
];
```

### Control Panel Middleware

Control panel middleware an be configured in your application's HTTP kernel. By default, the **web** middleware group is passed through as well.

```php
// app/Http/Kernel.php

protected $middlewareGroups = [
    'cp' => [
        AuthenticateCp::class,
    ],
];
```

### Routes File

You can use the the `routes/cp.php` file to define additional routes for the control panel. Routes defined there will be automatically prefixed and grouped.
