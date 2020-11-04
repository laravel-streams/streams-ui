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
            'workflow' => ControlPanelWorkflow::class,
        ], $attributes));
    }
}
