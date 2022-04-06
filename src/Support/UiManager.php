<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class UiManager
{
    use Macroable;
    use FiresCallbacks;

    protected array $components;

    public function __construct()
    {
        $this->components = [
            'form' => \Streams\Ui\Components\Form::class,
            'input' => \Streams\Ui\Components\Input::class,
            'table' => \Streams\Ui\Components\Table::class,
            'alert' => \Streams\Ui\Components\Alert::class,
            'avatar' => \Streams\Ui\Components\Avatar::class,
            'button' => \Streams\Ui\Components\Button::class,
            'cp' => \Streams\Ui\Components\ControlPanel::class,
            'dropdown' => \Streams\Ui\Components\Dropdown::class,

            'array' => \Streams\Ui\Components\Input::class,
            'string' => \Streams\Ui\Components\Input::class,
            'object' => \Streams\Ui\Components\Input::class,

            'date' => \Streams\Ui\Components\Inputs\Date::class,
            'slug' => \Streams\Ui\Components\Inputs\Slug::class,
            'color' => \Streams\Ui\Components\Inputs\Color::class,
            'number' => \Streams\Ui\Components\Inputs\Number::class,
            'select' => \Streams\Ui\Components\Inputs\Select::class,
            'toggle' => \Streams\Ui\Components\Inputs\Toggle::class,
            'decimal' => \Streams\Ui\Components\Inputs\Decimal::class,
            'integer' => \Streams\Ui\Components\Inputs\Integer::class,
            'textarea' => \Streams\Ui\Components\Inputs\Textarea::class,
            'markdown' => \Streams\Ui\Components\Inputs\Markdown::class,
            'relationship' => \Streams\Ui\Components\Inputs\Relationship::class,
            
            'boolean' => \Streams\Ui\Components\Inputs\Toggle::class,
        ];
    }

    public function make(string $name, array $attributes = []): Component
    {
        if (!$component = Arr::get($this->components, $name)) {
            throw new \Exception("Component [$name] does not exist.");
        }

        // @todo Callbacks
        return App::make($component, [
            'attributes' => $attributes,
        ]);
    }

    public function register($name, $component): static
    {
        $this->components[$name] = $component;

        return $this;
    }

    public function getComponents()
    {
        return $this->components;
    }

    // protected $buttons = [

    //     /*
    //      * Default Buttons
    //      */
    //     'default'       => [
    //         'context' => 'default',
    //     ],
    //     'cancel'        => [
    //         'text' => 'ui::buttons.cancel',
    //         'context' => 'default',
    //         'attributes' => [
    //             'data-keymap' => 'c',
    //         ],
    //     ],

    //     /*
    //      * Primary Buttons
    //      */
    //     'options'       => [
    //         'text' => 'ui::buttons.options',
    //         'context' => 'primary',
    //         'icon' => 'cog',
    //     ],
    //     'versions'      => [
    //         'text'    => 'ui::buttons.versions',
    //         'type'    => 'primary',
    //         'icon'    => 'history',
    //         'enabled' => 'edit',
    //     ],
    //     'load'          => [
    //         'icon'         => 'repeat',
    //         'data-icon'    => 'warning',
    //         'data-toggle'  => 'confirm',
    //         'type'         => 'primary',
    //         'text'         => 'ui::buttons.load',
    //         'data-title'   => 'ui::message.confirm_load_title',
    //         'data-message' => 'ui::message.confirm_load_message',
    //     ],
    //     'primary'       => [
    //         'context' => 'primary',
    //     ],

    //     /*
    //      * Success Buttons
    //      */
    //     'green'         => [
    //         'context' => 'success',
    //     ],
    //     'success'       => [
    //         'icon' => 'check',
    //         'context' => 'success',
    //     ],
    //     'save'          => [
    //         'text' => 'ui::buttons.save',
    //         'icon' => 'save',
    //         'context' => 'success',
    //         'attributes' => [
    //             'data-keymap' => 'command+s',
    //         ]
    //     ],
    //     'update'        => [
    //         'text' => 'ui::buttons.save',
    //         'icon' => 'save',
    //         'context' => 'success',
    //     ],
    //     'create'        => [
    //         'text' => 'ui::buttons.create',
    //         'icon' => 'fa fa-asterisk',
    //         'context' => 'success',
    //         'primary' => true,
    //         'attributes' => [
    //             'data-keymap' => 'n',
    //         ],
    //     ],
    //     'new'           => [
    //         'text' => 'ui::buttons.new',
    //         'icon' => 'fa fa-plus',
    //         'context' => 'success',
    //         'primary' => true,
    //         'attributes' => [
    //             'data-keymap' => 'n',
    //         ],
    //     ],
    //     'new_field'     => [
    //         'text' => 'ui::buttons.new_field',
    //         'icon' => 'fa fa-plus',
    //         'context' => 'success',
    //     ],
    //     'add'           => [
    //         'text' => 'ui::buttons.add',
    //         'icon' => 'fa fa-plus',
    //         'context' => 'success',
    //         'attributes' => [
    //             'data-keymap' => 'a',
    //         ],
    //     ],
    //     'add_all'       => [
    //         'text' => 'ui::buttons.add_all',
    //         'icon' => 'fa fa-plus-circle',
    //         'context' => 'success',
    //     ],
    //     'add_field'     => [
    //         'text' => 'ui::buttons.add_field',
    //         'icon' => 'fa fa-plus',
    //         'context' => 'success',
    //         'primary' => true,
    //     ],
    //     'add_selected'       => [
    //         'text' => 'ui::buttons.add_selected',
    //         'icon' => 'fa fa-check-circle',
    //         'context' => 'success',
    //     ],
    //     'assign_fields' => [
    //         'text' => 'ui::buttons.assign_fields',
    //         'icon' => 'fa fa-plus',
    //         'context' => 'success',
    //         'primary' => true,
    //     ],
    //     'send'          => [
    //         'text' => 'ui::buttons.send',
    //         'icon' => 'envelope',
    //         'context' => 'success',
    //     ],
    //     'submit'        => [
    //         'text' => 'ui::buttons.submit',
    //         'context' => 'success',
    //     ],
    //     'install'       => [
    //         'text' => 'ui::buttons.install',
    //         'icon' => 'download',
    //         'context' => 'success',
    //     ],
    //     'entries'       => [
    //         'text' => 'ui::buttons.entries',
    //         'icon' => 'list-ol',
    //         'context' => 'success',
    //     ],
    //     'done'          => [
    //         'text' => 'ui::buttons.done',
    //         'context' => 'success',
    //         'icon' => 'check',
    //     ],
    //     'select'        => [
    //         'text' => 'ui::buttons.select',
    //         'context' => 'success',
    //         'icon' => 'check',
    //     ],
    //     'restore'       => [
    //         'text' => 'ui::buttons.restore',
    //         'context' => 'success',
    //         'icon' => 'repeat',
    //     ],
    //     'finish'        => [
    //         'text' => 'ui::buttons.finish',
    //         'context' => 'success',
    //         'icon' => 'check',
    //     ],
    //     'finished'      => [
    //         'text' => 'ui::buttons.finished',
    //         'context' => 'success',
    //         'icon' => 'check',
    //     ],

    //     /*
    //      * Info Buttons
    //      */
    //     'blue'          => [
    //         'context' => 'info',
    //     ],
    //     'info'          => [
    //         'context' => 'info',
    //     ],
    //     'information'   => [
    //         'text' => 'ui::buttons.info',
    //         'icon' => 'fa fa-info',
    //         'context' => 'info',
    //     ],
    //     'help'          => [
    //         'icon'        => 'circle-question-mark',
    //         'text'        => 'ui::buttons.help',
    //         'type'        => 'info',
    //         'data-toggle' => 'modal',
    //         'data-target' => '#modal',
    //     ],
    //     'view'          => [
    //         'text' => 'ui::buttons.view',
    //         'icon' => 'fa fa-eye',
    //         'context' => 'info',
    //     ],
    //     'export'        => [
    //         'text' => 'ui::buttons.export',
    //         'icon' => 'download',
    //         'context' => 'info',
    //     ],
    //     'fields'        => [
    //         'text' => 'ui::buttons.fields',
    //         'icon' => 'list-alt',
    //         'context' => 'info',
    //     ],
    //     'assignments'   => [
    //         'text' => 'ui::buttons.assignments',
    //         'icon' => 'list-alt',
    //         'context' => 'info',
    //     ],
    //     'settings'      => [
    //         'text' => 'ui::buttons.settings',
    //         'context' => 'info',
    //         'icon' => 'cog',
    //     ],
    //     'preferences'   => [
    //         'text' => 'ui::buttons.preferences',
    //         'context' => 'info',
    //         'icon' => 'sliders',
    //     ],
    //     'configure'     => [
    //         'text' => 'ui::buttons.configure',
    //         'icon' => 'wrench',
    //         'context' => 'info',
    //     ],

    //     /*
    //      * Warning Buttons
    //      */
    //     'orange'        => [
    //         'context' => 'warning',
    //     ],
    //     'warning'       => [
    //         'icon' => 'warning',
    //         'context' => 'warning',
    //     ],
    //     'edit'          => [
    //         'text' => 'ui::buttons.edit',
    //         'icon' => 'pencil',
    //         'context' => 'warning',
    //     ],
    //     'change'        => [
    //         'text' => 'ui::buttons.change',
    //         'context' => 'warning',
    //         'icon' => 'cog',
    //     ],

    //     /*
    //      * Danger Buttons
    //      */
    //     'red'           => [
    //         'context' => 'danger',
    //     ],
    //     'danger'        => [
    //         'icon' => 'fa fa-exclamation-circle',
    //         'context' => 'danger',
    //     ],
    //     'remove'        => [
    //         'text' => 'ui::buttons.remove',
    //         'context' => 'danger',
    //         'icon' => 'ban',
    //     ],
    //     'delete'        => [
    //         'icon'       => 'trash',
    //         'type'       => 'danger',
    //         'text'       => 'ui::buttons.delete',
    //         'attributes' => [
    //             'data-toggle'  => 'confirm',
    //             'data-icon'    => 'warning',
    //             'data-title'   => 'ui::message.confirm_delete_title',
    //             'data-message' => 'ui::message.confirm_delete_message',
    //         ],
    //     ],
    //     'prompt'        => [
    //         'icon'       => 'trash',
    //         'type'       => 'danger',
    //         'segment'    => 'delete',
    //         'text'       => 'ui::buttons.delete',
    //         'attributes' => [
    //             'data-match'   => 'yes',
    //             'data-toggle'  => 'prompt',
    //             'data-icon'    => 'warning',
    //             'data-title'   => 'ui::message.prompt_delete_title',
    //             'data-message' => 'ui::message.prompt_delete_message',
    //         ],
    //     ],
    //     'uninstall'     => [
    //         'type'       => 'danger',
    //         'icon'       => 'times-circle',
    //         'text'       => 'ui::buttons.uninstall',
    //         'attributes' => [
    //             'data-toggle'  => 'prompt',
    //             'data-icon'    => 'warning',
    //             'data-title'   => 'ui::message.confirm_uninstall_title',
    //             'data-message' => 'ui::message.confirm_uninstall_message',
    //         ],
    //     ],
    // ];
}
