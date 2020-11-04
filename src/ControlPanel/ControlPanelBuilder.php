<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Str;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Normalizer;
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
                'make_shortcuts' => [$this, 'makeShortcuts'],
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
}
