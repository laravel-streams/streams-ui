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

            'workflows' => [
                //'build' => BuildControlPanel::class,
                'navigation' => BuildNavigation::class,
                //'shortcuts' => BuildShortcuts::class,
            ],
        ], $attributes));
    }

    public function buildNavigation()
    {
        if ($this->navigation === false) {
            return;
        }

        /**
         * If no navigation is set
         * then make a navigation
         * item for each stream.
         */
        $navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get()
            ->toArray();

        
        foreach ($navigation as $handle => &$item) {

            // Default the handle.
            if (!isset($item['handle']) && isset($item['id'])) {
                $item['handle'] = $item['id'];
            }

            // Default the handle more.
            if (!isset($item['handle']) && !is_numeric($handle)) {
                $item['handle'] = $handle;
            }

            // Default the stream for now.
            if (!isset($item['stream']) && Streams::has($item['handle'])) {
                $item['stream'] = $item['handle'];
            }
        }

        $navigation = Normalizer::attributes($navigation);
        
        foreach ($navigation as $handle => &$item) {

            // Load the stream.
            if (isset($item['stream']) && !$item['stream'] instanceof Stream) {
                $item['stream'] = Streams::make($item['stream']);
            }

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
        if ($this->shortcuts === false) {
            return;
        }

        $shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();

        foreach ($shortcuts as $handle => &$item) {

            // Default the handle.
            if (!isset($item['handle']) && isset($item['id'])) {
                $item['handle'] = $item['id'];
            }

            // Default the handle more.
            if (!isset($item['handle']) && !is_numeric($handle)) {
                $item['handle'] = $handle;
            }

            // Default the stream for now.
            if (!isset($item['stream']) && Streams::has($item['handle'])) {
                $item['stream'] = $item['handle'];
            }
        }

        $shortcuts = Normalizer::attributes($shortcuts);

        foreach ($shortcuts as $handle => &$item) {

            // Load the stream.
            if (isset($item['stream']) && !$item['stream'] instanceof Stream) {
                $item['stream'] = Streams::make($item['stream']);
            }

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
        foreach ($shortcuts as $parameters) {

            $instance = new Shortcut($parameters);

            $this->instance->shortcuts->put($instance->handle, $instance);
        }
        
        $this->shortcuts = $shortcuts;
    }
}
