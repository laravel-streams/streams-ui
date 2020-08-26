<?php

namespace Anomaly\Streams\Ui\Button;

use Illuminate\Support\Arr;

/**
 * Class ButtonRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonRegistry
{

    /**
     * Available buttons.
     *
     * @var array
     */
    protected $buttons = [

        /*
         * Default Buttons
         */
        'default'       => [
            'context' => 'default',
        ],
        'cancel'        => [
            'text' => 'ui::button.cancel',
            'context' => 'default',
            'attributes' => [
                'data-keymap' => 'c',
            ],
        ],

        /*
         * Primary Buttons
         */
        'options'       => [
            'text' => 'ui::button.options',
            'context' => 'primary',
            'icon' => 'cog',
        ],
        'versions'      => [
            'text'    => 'ui::button.versions',
            'type'    => 'primary',
            'icon'    => 'history',
            'enabled' => 'edit',
        ],
        'load'          => [
            'icon'         => 'repeat',
            'data-icon'    => 'warning',
            'data-toggle'  => 'confirm',
            'type'         => 'primary',
            'text'         => 'ui::button.load',
            'data-title'   => 'ui::message.confirm_load_title',
            'data-message' => 'ui::message.confirm_load_message',
        ],
        'primary'       => [
            'context' => 'primary',
        ],
        
        /*
         * Success Buttons
         */
        'green'         => [
            'context' => 'success',
        ],
        'success'       => [
            'icon' => 'check',
            'context' => 'success',
        ],
        'save'          => [
            'text' => 'ui::button.save',
            'icon' => 'save',
            'context' => 'success',
        ],
        'update'        => [
            'text' => 'ui::button.save',
            'icon' => 'save',
            'context' => 'success',
        ],
        'create'        => [
            'text' => 'ui::button.create',
            'icon' => 'fa fa-asterisk',
            'context' => 'success',
            'primary' => true,
        ],
        'new'           => [
            'text' => 'ui::button.new',
            'icon' => 'fa fa-plus',
            'context' => 'success',
            'primary' => true,
            'attributes' => [
                'data-keymap' => 'n',
            ],
        ],
        'new_field'     => [
            'text' => 'ui::button.new_field',
            'icon' => 'fa fa-plus',
            'context' => 'success',
        ],
        'add'           => [
            'text' => 'ui::button.add',
            'icon' => 'fa fa-plus',
            'context' => 'success',
            'attributes' => [
                'data-keymap' => 'a',
            ],
        ],
        'add_all'       => [
            'text' => 'ui::button.add_all',
            'icon' => 'fa fa-plus-circle',
            'context' => 'success',
        ],
        'add_field'     => [
            'text' => 'ui::button.add_field',
            'icon' => 'fa fa-plus',
            'context' => 'success',
            'primary' => true,
        ],
        'add_selected'       => [
            'text' => 'ui::button.add_selected',
            'icon' => 'fa fa-check-circle',
            'context' => 'success',
        ],
        'assign_fields' => [
            'text' => 'ui::button.assign_fields',
            'icon' => 'fa fa-plus',
            'context' => 'success',
            'primary' => true,
        ],
        'send'          => [
            'text' => 'ui::button.send',
            'icon' => 'envelope',
            'context' => 'success',
        ],
        'submit'        => [
            'text' => 'ui::button.submit',
            'context' => 'success',
        ],
        'install'       => [
            'text' => 'ui::button.install',
            'icon' => 'download',
            'context' => 'success',
        ],
        'entries'       => [
            'text' => 'ui::button.entries',
            'icon' => 'list-ol',
            'context' => 'success',
        ],
        'done'          => [
            'text' => 'ui::button.done',
            'context' => 'success',
            'icon' => 'check',
        ],
        'select'        => [
            'text' => 'ui::button.select',
            'context' => 'success',
            'icon' => 'check',
        ],
        'restore'       => [
            'text' => 'ui::button.restore',
            'context' => 'success',
            'icon' => 'repeat',
        ],
        'finish'        => [
            'text' => 'ui::button.finish',
            'context' => 'success',
            'icon' => 'check',
        ],
        'finished'      => [
            'text' => 'ui::button.finished',
            'context' => 'success',
            'icon' => 'check',
        ],

        /*
         * Info Buttons
         */
        'blue'          => [
            'context' => 'info',
        ],
        'info'          => [
            'context' => 'info',
        ],
        'information'   => [
            'text' => 'ui::button.info',
            'icon' => 'fa fa-info',
            'context' => 'info',
        ],
        'help'          => [
            'icon'        => 'circle-question-mark',
            'text'        => 'ui::button.help',
            'type'        => 'info',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
        ],
        'view'          => [
            'text' => 'ui::button.view',
            'icon' => 'fa fa-eye',
            'context' => 'info',
        ],
        'export'        => [
            'text' => 'ui::button.export',
            'icon' => 'download',
            'context' => 'info',
        ],
        'fields'        => [
            'text' => 'ui::button.fields',
            'icon' => 'list-alt',
            'context' => 'info',
        ],
        'assignments'   => [
            'text' => 'ui::button.assignments',
            'icon' => 'list-alt',
            'context' => 'info',
        ],
        'settings'      => [
            'text' => 'ui::button.settings',
            'context' => 'info',
            'icon' => 'cog',
        ],
        'preferences'   => [
            'text' => 'ui::button.preferences',
            'context' => 'info',
            'icon' => 'sliders',
        ],
        'configure'     => [
            'text' => 'ui::button.configure',
            'icon' => 'wrench',
            'context' => 'info',
        ],

        /*
         * Warning Buttons
         */
        'orange'        => [
            'context' => 'warning',
        ],
        'warning'       => [
            'icon' => 'warning',
            'context' => 'warning',
        ],
        'edit'          => [
            'text' => 'ui::button.edit',
            'icon' => 'pencil',
            'context' => 'warning',
        ],
        'change'        => [
            'text' => 'ui::button.change',
            'context' => 'warning',
            'icon' => 'cog',
        ],
        
        /*
         * Danger Buttons
         */
        'red'           => [
            'context' => 'danger',
        ],
        'danger'        => [
            'icon' => 'fa fa-exclamation-circle',
            'context' => 'danger',
        ],
        'remove'        => [
            'text' => 'ui::button.remove',
            'context' => 'danger',
            'icon' => 'ban',
        ],
        'delete'        => [
            'icon'       => 'trash',
            'type'       => 'danger',
            'text'       => 'ui::button.delete',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-icon'    => 'warning',
                'data-title'   => 'ui::message.confirm_delete_title',
                'data-message' => 'ui::message.confirm_delete_message',
            ],
        ],
        'prompt'        => [
            'icon'       => 'trash',
            'type'       => 'danger',
            'segment'    => 'delete',
            'text'       => 'ui::button.delete',
            'attributes' => [
                'data-match'   => 'yes',
                'data-toggle'  => 'prompt',
                'data-icon'    => 'warning',
                'data-title'   => 'ui::message.prompt_delete_title',
                'data-message' => 'ui::message.prompt_delete_message',
            ],
        ],
        'uninstall'     => [
            'type'       => 'danger',
            'icon'       => 'times-circle',
            'text'       => 'ui::button.uninstall',
            'attributes' => [
                'data-toggle'  => 'prompt',
                'data-icon'    => 'warning',
                'data-title'   => 'ui::message.confirm_uninstall_title',
                'data-message' => 'ui::message.confirm_uninstall_message',
            ],
        ],
    ];

    /**
     * Get a button.
     *
     * @param  $button
     * @return array|null
     */
    public function get($button)
    {
        if (!$button) {
            return null;
        }

        return Arr::get($this->buttons, $button);
    }

    /**
     * Register a button.
     *
     * @param        $button
     * @param  array $parameters
     * @return $this
     */
    public function register($button, array $parameters)
    {
        Arr::set($this->buttons, $button, $parameters);

        return $this;
    }

    /**
     * Get the buttons.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the buttons.
     *
     * @param array $buttons
     * @return $this
     */
    public function setButtons(array $buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }
}
