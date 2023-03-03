<?php

return [

    'admin' => [
        'prefix' => 'admin',
        'enabled' => env('STREAMS_ADMIN_ENABLED', true),
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
        //'table.views' => \Streams\Ui\Components\Table\TableViews::class,
        'table.header' => \Streams\Ui\Components\Table\TableHeader::class,
        'table.column' => \Streams\Ui\Components\Table\TableColumn::class,
        //'table.filters' => \Streams\Ui\Components\Table\TableFilters::class,

        'tabs' => \Streams\Ui\Components\Tabs::class,

        'menu' => \Streams\Ui\Components\Menu::class,
        // 'menu.item' => \Streams\Ui\Components\Menu\MenuItem::class,

        'navigation' => \Streams\Ui\Components\Navigation::class,
        // 'navigation.item' => \Streams\Ui\Components\Navigation\NavigationItem::class,
        
        'collapsable' => \Streams\Ui\Components\Collapsable::class,

        'avatar' => \Streams\Ui\Components\Avatar::class,
        'anchor' => \Streams\Ui\Components\Anchor::class,
        'button' => \Streams\Ui\Components\Button::class,
        'indicator' => \Streams\Ui\Components\Indicator::class,
        'breadcrumbs' => \Streams\Ui\Components\Breadcrumbs::class,
        
        'dropdown' => \Streams\Ui\Components\Dropdown::class,
        //'dropdown.item' => \Streams\Ui\Components\Dropdown\DropdownItem::class,
        
        'modal' => \Streams\Ui\Components\Modal::class,
        //'modal.header' => \Streams\Ui\Components\Modal\ModalHeader::class,
        //'modal.content' => \Streams\Ui\Components\Modal\ModalContent::class,
        //'modal.footer' => \Streams\Ui\Components\Modal\ModalFooter::class,


        /**
         * Inputs are matched to
         * one or more field types.
         */
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
        'enum' => \Streams\Ui\Components\Inputs\SelectInput::class, // @todo - register with below

        'color' => \Streams\Ui\Components\Inputs\ColorInput::class,

        'url-input' => \Streams\Ui\Components\Inputs\UrlInput::class,
        'text' => \Streams\Ui\Components\Inputs\TextInput::class,
        'input' => \Streams\Ui\Components\Inputs\TextInput::class,
        'email' => \Streams\Ui\Components\Inputs\EmailInput::class,

        'tags' => \Streams\Ui\Components\Inputs\TagsInput::class,

        'file' => \Streams\Ui\Components\Inputs\FileInput::class,

        'checkbox' => \Streams\Ui\Components\Inputs\CheckboxInput::class,

        'textarea' => \Streams\Ui\Components\Inputs\TextareaInput::class,


        /**
         * Admin Components
         */
        'admin' => \Streams\Ui\Components\Admin\AdminDashboard::class,
        'admin.menu' => \Streams\Ui\Components\Admin\AdminMenu::class,
        'admin.navigation' => \Streams\Ui\Components\Admin\AdminNavigation::class,


        /**
         * @todo Use the registry system for these. Configurable. Maybe even all FTs. 
         * 
         * input = hash|uuid|string|array|boolean
         * type = registered from above
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
