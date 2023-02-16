<?php

return [

    'admin' => [
        'prefix' => 'admin',
        'enabled' => env('ADMIN_ENABLED', true),
        'default' => \Streams\Ui\Components\Admin\AdminDashboard::class,
        'navigation' => [
            [
                'text' => 'Dashboard',
                'url' => '/admin',
                'sort_order' => 0,
                'component' => 'anchor',
            ],
        ],
        'buttons' => [],
        'menu' => [],
        //'actions' => [],
    ],

    /**
     * Registered components.
     * 
     * @livewire($name, $class)
     */
    'components' => [
        'form' => \Streams\Ui\Components\Form::class,
        'field' => \Streams\Ui\Components\Field::class,

        'table' => \Streams\Ui\Components\Table::class,
        'table.row' => \Streams\Ui\Components\Table\TableRow::class,
        'table.header' => \Streams\Ui\Components\Table\TableHeader::class,
        'table.column' => \Streams\Ui\Components\Table\TableColumn::class,

        'navigation' => \Streams\Ui\Components\Navigation::class,

        'anchor' => \Streams\Ui\Components\Anchor::class,
        'button' => \Streams\Ui\Components\Button::class,

        'image' => \Streams\Ui\Components\Image::class,

        // Inputs
        'date' => \Streams\Ui\Components\Inputs\DateInput::class,
        'time' => \Streams\Ui\Components\Inputs\TimeInput::class,
        'datetime-input' => \Streams\Ui\Components\Inputs\DatetimeInput::class,

        'slug' => \Streams\Ui\Components\Inputs\SlugInput::class,

        'editor' => \Streams\Ui\Components\Inputs\EditorInput::class,
        'object' => \Streams\Ui\Components\Inputs\EditorInput::class,
        'markdown' => \Streams\Ui\Components\Inputs\MarkdownInput::class,
        // 'checkboxes' => \Streams\Ui\Components\Inputs\Checkboxes::class,
        // 'relationship' => \Streams\Ui\Components\Inputs\Relationship::class,

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

        'tags' => \Streams\Ui\Components\Inputs\TagsInput::class,

        'file' => \Streams\Ui\Components\Inputs\FileInput::class,

        'checkbox' => \Streams\Ui\Components\Inputs\CheckboxInput::class,

        'textarea' => \Streams\Ui\Components\Inputs\TextareaInput::class,


        // Admin Components
        'admin' => \Streams\Ui\Components\Admin\AdminDashboard::class,
        'admin.menu' => \Streams\Ui\Components\Admin\AdminMenu::class,
        'admin.navigation' => \Streams\Ui\Components\Admin\AdminNavigation::class,


        /**
         * These field type defaults need to be mapped.
         */
        'hash' => \Streams\Ui\Components\Inputs\TextInput::class,
        'uuid' => \Streams\Ui\Components\Inputs\TextInput::class,
        'string' => \Streams\Ui\Components\Inputs\TextInput::class,

        'array' => \Streams\Ui\Components\Inputs\TagsInput::class,

        'boolean' => \Streams\Ui\Components\Inputs\CheckboxInput::class,
    ],

    'buttons' => [

        'create' => [
            'text' => 'ui::buttons.create',
            'attributes' => [
                'data-keymap' => 'n',
            ],
        ],
        'edit' => [
            'text' => 'ui::buttons.edit',
            'attributes' => [
                'data-keymap' => 'n',
            ],
        ],
        'save' => [
            'text' => 'ui::buttons.save',
            'attributes' => [
                'data-keymap' => 'command+s',
            ]
        ],
        'cancel' => [
            'text' => 'ui::buttons.cancel',
            'attributes' => [
                'data-keymap' => 'cmd+esc',
            ],
        ],
        'delete' => [
            'text' => 'ui::buttons.delete',
        ],
    ],
];
