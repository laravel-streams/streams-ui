<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Button\ButtonRegistry;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanel;
use Streams\Ui\ControlPanel\Component\Shortcut\Shortcut;
use Streams\Ui\ControlPanel\Component\Navigation\NavigationLink;

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
                'make_control_panel' => [$this, 'makeControlPanel'],

                'make_navigation' => [$this, 'makeNavigation'],
                'detect_navigation' => [$this, 'detectNavigation'],

                'make_shortcuts' => [$this, 'makeShortcuts'],
                'make_buttons' => [$this, 'makeButtons'],
            ],

            'component' => 'control_panel',
            'control_panel' => ControlPanel::class,
        ], $attributes));
    }

    public function makeControlPanel()
    {
        $this->instance = new ControlPanel();
    }

    public function makeNavigation()
    {
        $navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get()
            ->toArray();

        $navigation = Normalizer::fillWithAttribute($navigation, 'handle', 'id');
        $navigation = Normalizer::htmlAttributes($navigation);

        foreach ($navigation as $handle => &$item) {

            if (!isset($item['title'])) {
                $item['title'] = Str::title($handle);
            }
        }

        array_map(function ($attributes) {
            $this->instance->navigation->put($attributes['handle'], new NavigationLink($attributes));
        }, $navigation);

        $this->navigation = $navigation;
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

        if ($match) {
            $match->active = true;
        }
    }

    public function makeShortcuts()
    {
        $shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();

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

        $shortcuts = Normalizer::fillWithAttribute($shortcuts, 'handle', 'id');
        $shortcuts = Normalizer::htmlAttributes($shortcuts);

        array_map(function ($attributes) {
            $this->instance->shortcuts->put($attributes['handle'], new Shortcut($attributes));
        }, $shortcuts);

        $this->shortcuts = $shortcuts;
    }

    public function makeButtons()
    {
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

        foreach ($buttons as &$attributes) {

            if (isset($attributes['attributes']['href'])) {
                continue;
            }

            switch ($attributes['handle']) {
                case 'create':
                    $attributes['attributes']['href'] = Request::fullUrl() . '/create';
                    break;

                default:
                    # code...
                    break;
            }
        }

        $this->loadInstanceWith('buttons', $buttons, Button::class);

        $this->buttons = $buttons;
    }
}
