<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Str;
use Streams\Ui\Support\Builder;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Normalizer;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\Component\Navigation\NavigationLink;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\BuildShortcuts;
use Streams\Ui\ControlPanel\Component\Navigation\Workflows\BuildNavigation;
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

            'component' => 'control_panel',
            'control_panel' => ControlPanel::class,

            'steps' => [
                [$this, 'make'],
                [$this, 'buildNavigation'],
                [$this, 'buildShortcuts'],
            ],
        ], $attributes));
    }

    public function buildNavigation()
    {
        $navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get()
            ->toArray();


        $navigation = Normalizer::fillWithAttribute($navigation, 'handle', 'id');
        $navigation = Normalizer::htmlAttributes($navigation);

        foreach ($navigation as $handle => &$item) {

            // Guess the title from the stream.
            if (!isset($item['title'])) {

                if (isset($item['stream'])) {

                    $item['title'] = $item['stream']->name ?: Str::title($item['stream']->handle);

                    continue;
                }

                $item['title'] = Str::title($handle);
            }
        }

        /**
         * Foreach array defintion build
         * a new prototype component.
         */
        foreach ($navigation as $parameters) {

            $instance = new NavigationLink($parameters);

            $this->instance->navigation->put($instance->handle, $instance);
        }

        $this->navigation = $navigation;
    }

    public function buildShortcuts()
    {
        $shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();

        $shortcuts = Normalizer::fillWithAttribute($shortcuts, 'handle', 'id');
        $shortcuts = Normalizer::htmlAttributes($shortcuts);

        array_map(function ($attributes) {
            $this->instance->shortcuts->put(
                $attributes['handle'],
                new Shortcut($attributes)
            );
        }, $shortcuts);

        $this->shortcuts = $shortcuts;
    }
}
