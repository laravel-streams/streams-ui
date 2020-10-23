<?php

namespace Streams\Ui\ControlPanel\Component\Navigation;

use Streams\Ui\Support\Component;

/**
 * Class NavigationLink
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationLink extends Component
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
            'component' => 'navigation_link',
            'template' => 'ui::cp.navigation_link',

            'handle' => null,
            'title' => null,
            'policy' => null,
            'breadcrumb' => null,
            
            'active' => false,
            'favorite' => false,
            
            'buttons' => [],
        ], $attributes));
    }
}
