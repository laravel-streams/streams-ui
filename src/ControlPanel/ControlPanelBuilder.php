<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Button\ButtonRegistry;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanel;
use Streams\Ui\ControlPanel\Component\Shortcut\Shortcut;

/**
 * Class ControlPanelBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanelBuilder extends Builder
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'stream' => null,
            'options' => [],

            'navigation' => [],

            'steps' => [
                'make_control_panel' => [$this, 'make'],

                'make_navigation' => [$this, 'makeNavigation'],
                'detect_navigation' => [$this, 'detectNavigation'],

                'make_shortcuts' => [$this, 'makeShortcuts'],
                'make_buttons' => [$this, 'makeButtons'],
            ],

            'component' => 'control_panel',
            'control_panel' => ControlPanel::class,
        ], $attributes));
    }

    public function makeNavigation()
    {
        $this->make();

        if ($this->instance->navigation->isNotEmpty()) {
            return $this->instance->navigation;
        }
        
        $navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get();

        return $this->instance->navigation = $navigation;
    }

    public function detectNavigation()
    {
        $match = null;

        $url = Request::fullUrl();

        foreach ($this->instance->navigation as $link) {

            if (!Str::contains($url, $link->url())) {
                continue;
            }

            if ($match && strlen($link->url() > strlen($match->url()))) {
                $match = $link;
            }

            $match = $link;
        }

        if ($match && $match->parent) {
            
            $parent = $this->instance->navigation->get($match->parent);

            $match->buttons = $match->buttons ?: $parent->buttons;
        }

        if ($match) {
            
            $match->active = true;

            $this->stream = $this->stream ?: $match->stream;
            $this->entry = $this->entry ?: $match->entry;
        }
    }

    public function makeShortcuts()
    {
        $this->make();

        if ($this->instance->shortcuts->isNotEmpty()) {
            return $this->instance->shortcuts;
        }

        $shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'desc')
            ->get();

        // 'view_site' => [
        //     'href'   => '/',
        //     'class'  => 'button',
        //     'target' => '_blank',
        //     'title'  => 'anomaly.theme.flow::control_panel.view_site',
        // ],
        // 'logout' => [
        //     'class' => 'button',
        //     'href'  => 'streams::cp.logout',
        //     'title' => 'anomaly.theme.flow::control_panel.logout',
        // ],

        return $this->instance->shortcuts = $shortcuts;
    }

    public function makeButtons()
    {
        $this->make();

        if ($this->instance->buttons->isNotEmpty()) {
            return $this->instance->buttons;
        }

        if (!$active = $this->instance->navigation->active()) {
            return;
        }

        $buttons = $active->buttons;

        $buttons = Normalizer::normalize($buttons);
        $buttons = Normalizer::fillWithKey($buttons, 'handle');
        $buttons = Normalizer::fillWithAttribute($buttons, 'button', 'handle');

        $registry = app(ButtonRegistry::class);

        foreach ($buttons as &$attributes) {
            if ($registered = $registry->get(Arr::pull($attributes, 'button'))) {
                $attributes = array_replace_recursive($registered, $attributes);
            }
        }

        $buttons = Normalizer::attributes($buttons);
        $buttons = Normalizer::dropdown($buttons);

        foreach ($buttons as &$attributes) {

            if (isset($attributes['attributes']['href'])) {
                continue;
            }

            switch ($attributes['handle']) {
                case 'create':
                    $attributes['attributes']['href'] = $active->url() . '/create';
                    break;

                default:
                    # code...
                    break;
            }
        }

        $this->loadInstanceWith('buttons', $buttons, Button::class);

        $this->buttons = $buttons;

        return $this->instance->buttons;
    }
}
