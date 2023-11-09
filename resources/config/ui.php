<?php

return [

    'components' => [
        'anchor' => \Streams\Ui\Components\Anchor::class,
        'button' => \Streams\Ui\Components\Button::class,
    ],

    'livewire' => [

        // Generic Components
        'card' => \Streams\Ui\Components\Card::class,
        'tabs' => \Streams\Ui\Components\Tabs::class,
        'menu' => \Streams\Ui\Components\Menu::class,
        'badge' => \Streams\Ui\Components\Badge::class,
        'modal' => \Streams\Ui\Components\Modal::class,
        // 'anchor' => \Streams\Ui\Components\Anchor::class,
        'avatar' => \Streams\Ui\Components\Avatar::class,
        // 'button' => \Streams\Ui\Components\Button::class,
        'drawer' => \Streams\Ui\Components\Drawer::class,
        'drawer' => \Streams\Ui\Components\Drawer::class,
        'content' => \Streams\Ui\Components\Content::class,
        'dropdown' => \Streams\Ui\Components\Dropdown::class,
        'navigation' => \Streams\Ui\Components\Navigation::class,
        'breadcrumbs' => \Streams\Ui\Components\Breadcrumbs::class,
        'collapsable' => \Streams\Ui\Components\Collapsable::class,
        'notifications' => \Streams\Ui\Components\Notifications::class,

        // Control Panel
        'panel' => \Streams\Ui\Components\Panel::class,
        'admin.menu' => \Streams\Ui\Components\Admin\AdminMenu::class,
        'admin.login' => \Streams\Ui\Components\Admin\AdminLogin::class,
        'admin.navigation' => \Streams\Ui\Components\Admin\AdminNavigation::class,

        // Inputs
        'file' => \Streams\Ui\Components\Inputs\FileInput::class,
        'slug' => \Streams\Ui\Components\Inputs\SlugInput::class,
        'tags' => \Streams\Ui\Components\Inputs\TagsInput::class,
        'input' => \Streams\Ui\Components\Inputs\BasicInput::class,
        'range' => \Streams\Ui\Components\Inputs\RangeInput::class,
        'editor' => \Streams\Ui\Components\Inputs\EditorInput::class,
        'select' => \Streams\Ui\Components\Inputs\SelectInput::class,
        'toggle' => \Streams\Ui\Components\Inputs\ToggleInput::class,
        'checkbox' => \Streams\Ui\Components\Inputs\CheckboxInput::class,
        'markdown' => \Streams\Ui\Components\Inputs\MarkdownInput::class,
        'textarea' => \Streams\Ui\Components\Inputs\TextareaInput::class,
        
        
        // 'number' => \Streams\Ui\Components\Inputs\NumberInput::class,
        // 'decimal' => \Streams\Ui\Components\Inputs\DecimalInput::class,
        // 'integer' => \Streams\Ui\Components\Inputs\IntegerInput::class,
        
        // 'object' => \Streams\Ui\Components\Inputs\EditorInput::class,
        // 'checkboxes' => \Streams\Ui\Components\Inputs\Checkboxes::class,

        // WIP Inputs
        'relationship' => \Streams\Ui\Components\Inputs\BasicInput::class,

        'form' => \Streams\Ui\Components\Form::class,
        // 'field' => \Streams\Ui\Components\Field::class,

        'table' => \Streams\Ui\Components\Table::class,
        // 'table.row' => \Streams\Ui\Components\Table\TableRow::class,
        // //'table.views' => \Streams\Ui\Components\Table\TableViews::class,
        // 'table.header' => \Streams\Ui\Components\Table\TableHeader::class,
        // 'table.column' => \Streams\Ui\Components\Table\TableColumn::class,
        // 'table.filter' => \Streams\Ui\Components\Table\TableFilter::class,
    ],

    /**
     * Registered components.
     * 
     * @livewire($name, $class)
     */
    'aliases' => [

        /**
         * Input Variations
         */
        'array' => [
            'component' => 'tags',
        ],
        'boolean' => [
            'component' => 'checkbox',
        ],
        'enum' => [
            'component' => 'select',
        ],
        'text' => [
            'component' => 'input',
        ],
        'string' => [
            'component' => 'input',
        ],
        'uuid' => [
            'component' => 'input',
        ],
        'hash' => [
            'component' => 'input',
            'type' => 'password',
        ],
        'url' => [
            'component' => 'input',
            'type' => 'url',
        ],
        'date' => [
            'component' => 'input',
            'type' => 'date',
        ],
        'time' => [
            'component' => 'input',
            'type' => 'time',
        ],
        'datetime' => [
            'component' => 'input',
            'type' => 'datetime-local',
        ],
        'email' => [
            'component' => 'input',
            'type' => 'email',
        ],
        'color' => [
            'component' => 'input',
            'type' => 'color',
        ],
        'hidden' => [
            'component' => 'input',
            'type' => 'hidden',
        ],
        'password' => [
            'component' => 'input',
            'type' => 'password',
        ],
        
        /**
         * Button Variations
         */
        'button.edit' => [
            'component' => 'button',
            'tag' => 'a',
            'handle' => 'edit',
            'text' => 'Edit',
            'url' => '/{request.segments.0}/{request.segments.1}/{entry.id}/edit'
        ],
        'button.save' => [
            'component' => 'button',
            'type' => 'submit',
            'text' => 'Save',
        ],
        'button.cancel' => [
            'component' => 'button',
            'tag' => 'a',
            'handle' => 'cancel',
            'text' => 'Cancel',
            'url' => '/{request.segments.0}/{request.segments.1}'
        ],
        'button.delete' => [
            'tag' => 'button',
            'component' => 'button',
            'handle' => 'delete',
            'text' => 'Delete',
        ],
    ],
];
