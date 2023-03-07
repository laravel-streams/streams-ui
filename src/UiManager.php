<?php

namespace Streams\Ui;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Ui\Testing\TestableComponent;
use Streams\Core\Support\Traits\FiresCallbacks;

class UiManager
{
    use Macroable;
    use FiresCallbacks;

    protected array $components;

    public function __construct()
    {
        $this->components = Config::get('streams.ui.components', []);
    }

    public function exists(string $alias): bool
    {
        return App::has($alias);
    }

    public function make(string $alias, array $attributes = []): Component
    {
        if (!isset($this->components[$alias]) && class_exists($alias)) {
            return App::make($alias, [
                'attributes' => $attributes,
            ]);
        }
        
        if (!$component = Arr::get($this->components, $alias)) {
            throw new \Exception("Component [$alias] does not exist.");
        }

        if (is_array($component)) {
            
            $attributes = array_replace_recursive(Arr::except($component, 'component'), $attributes);

            $component = Arr::pull($component, 'component');
        }

        // @todo Callbacks and such
        return App::make($this->components[$component] ?? $component, [
            'attributes' => $attributes,
        ]);
    }

    public function test(string $alias, array $attributes = []): TestableComponent
    {
        return new TestableComponent($this->make($alias, $attributes));
    }

    public function component($alias, $component): static
    {
        $this->components[$alias] = $component;

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
