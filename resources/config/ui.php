<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

return [

    'components' => [
        'form' => \Streams\Ui\Components\Form::class,
        // 'alert' => \Streams\Ui\Components\Alert::class,
        // 'table' => \Streams\Ui\Components\Table::class,
        // 'modal' => \Streams\Ui\Components\Modal::class,
        // 'avatar' => \Streams\Ui\Components\Avatar::class,
        // 'cp' => \Streams\Ui\Components\ControlPanel::class,
        // 'dropdown' => \Streams\Ui\Components\Dropdown::class,

        'button' => \Streams\Ui\Components\Button::class,

        'field' => \Streams\Ui\Components\Field::class,

        // 'time' => \Streams\Ui\Components\Input::class,
        // 'datetime' => \Streams\Ui\Components\Input::class,

        // 'date' => \Streams\Ui\Components\Inputs\Date::class,
        // 'slug' => \Streams\Ui\Components\Inputs\Slug::class,
        // 'tags' => \Streams\Ui\Components\Inputs\Tags::class,
        // 'array' => \Streams\Ui\Components\Inputs\Tags::class,
        
        // 'editor' => \Streams\Ui\Components\Inputs\Editor::class,
        // 'markdown' => \Streams\Ui\Components\Inputs\Markdown::class,
        // 'checkboxes' => \Streams\Ui\Components\Inputs\Checkboxes::class,
        // 'relationship' => \Streams\Ui\Components\Inputs\Relationship::class,
        
        // 'url' => \Streams\Ui\Components\Input::class,
        // 'file' => \Streams\Ui\Components\Input::class,
        // 'hash' => \Streams\Ui\Components\Input::class,
        // 'uuid' => \Streams\Ui\Components\Input::class,
        // 'email' => \Streams\Ui\Components\Input::class,
        // 'object' => \Streams\Ui\Components\Input::class,
        
        'number' => \Streams\Ui\Components\Inputs\Number::class,
        'decimal' => \Streams\Ui\Components\Inputs\Decimal::class,
        'integer' => \Streams\Ui\Components\Inputs\Integer::class,

        // 'enum' => \Streams\Ui\Components\Inputs\SelectInput::class,
        // 'select' => \Streams\Ui\Components\Inputs\SelectInput::class,

        // 'color' => \Streams\Ui\Components\Inputs\ColorInput::class,

        'text' => \Streams\Ui\Components\Inputs\Text::class,
        'input' => \Streams\Ui\Components\Inputs\Text::class,
        //'string' => \Streams\Ui\Components\Inputs\TextInput::class,

        // 'boolean' => \Streams\Ui\Components\Inputs\CheckboxInput::class,
        // 'checkbox' => \Streams\Ui\Components\Inputs\CheckboxInput::class,

        'textarea' => \Streams\Ui\Components\Inputs\Textarea::class,
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
