<?php

return [

    'components' => [
        'form' => \Streams\Ui\Components\Form::class,
        
        'button' => \Streams\Ui\Components\Button::class,

        'field' => \Streams\Ui\Components\Field::class,

        // Inputs
        'date' => \Streams\Ui\Components\Inputs\DateInput::class,
        'time' => \Streams\Ui\Components\Inputs\TimeInput::class,
        'datetime-input' => \Streams\Ui\Components\Inputs\DatetimeInput::class,

        // 'slug' => \Streams\Ui\Components\Inputs\Slug::class,
        'tags' => \Streams\Ui\Components\Inputs\TagsInput::class,
        // 'array' => \Streams\Ui\Components\Inputs\Tags::class,
        
        // 'editor' => \Streams\Ui\Components\Inputs\Editor::class,
        // 'markdown' => \Streams\Ui\Components\Inputs\Markdown::class,
        // 'checkboxes' => \Streams\Ui\Components\Inputs\Checkboxes::class,
        // 'relationship' => \Streams\Ui\Components\Inputs\Relationship::class,
        
        // 'object' => \Streams\Ui\Components\Input::class,
        
        'range' => \Streams\Ui\Components\Inputs\RangeInput::class,

        'number' => \Streams\Ui\Components\Inputs\NumberInput::class,
        'decimal' => \Streams\Ui\Components\Inputs\DecimalInput::class,
        'integer' => \Streams\Ui\Components\Inputs\IntegerInput::class,

        'select' => \Streams\Ui\Components\Inputs\SelectInput::class,
        'enum' => \Streams\Ui\Components\Inputs\SelectInput::class, // @todo - remove

        'color' => \Streams\Ui\Components\Inputs\ColorInput::class,

        'url' => \Streams\Ui\Components\Inputs\UrlInput::class,
        'text' => \Streams\Ui\Components\Inputs\TextInput::class,
        'input' => \Streams\Ui\Components\Inputs\TextInput::class,
        'email' => \Streams\Ui\Components\Inputs\EmailInput::class,
        // 'hash' => \Streams\Ui\Components\Input::class,
        // 'uuid' => \Streams\Ui\Components\Input::class,
        // 'string' => \Streams\Ui\Components\Inputs\TextInput::class,

        'file' => \Streams\Ui\Components\Inputs\FileInput::class,

        'checkbox' => \Streams\Ui\Components\Inputs\CheckboxInput::class,
        // 'boolean' => \Streams\Ui\Components\Inputs\CheckboxInput::class,

        'textarea' => \Streams\Ui\Components\Inputs\TextareaInput::class,
    ],

    'inputs' => [
        'types' => [],
        'field_types' => [

            // Numbers
            // 'integer' => [
            //     'input' => 'number',
            //     'step' => 1,
            // ],
            // 'decimal' => [
            //     'input' => 'text',
            // ],

            // Strings
            // 'string' => [
            //     'input' => 'text',
            // ],
            // 'url' => [
            //     'input' => 'text',
            //     'type'  => 'url',
            // ],
            // 'uuid' => [
            //     'input' => 'text',
            // ],
            // 'hash' => [
            //     'input' => 'text',
            // ],
            // 'email' => [
            //     'input' => 'text',
            //     'type' => 'email',
            // ],
            // 'encrypted' => [
            //     'input' => 'text',
            //     'type' => 'password',
            // ],

            // // Boolean
            // 'boolean' => [
            //     // radio + options|checkbox
            // ],

            // // Arrays
            // 'array' => [
            //     // tags|items
            // ],

            // // Selections
            // 'enum' => [
            //     'type' => 'select',
            // ],

            // 'image' => [
            //     // file + accepts
            // ],
        ],
    ],

    // GET RID OF THIS
    /**
     * Specify whether the CP is enabled or not.
     */
    'cp_enabled' => env('STREAMS_CP_ENABLED', false),

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
];
