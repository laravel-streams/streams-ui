<?php

namespace Streams\Ui\Table\Component\View;

use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Workflows\BuildComponent;

/**
 * Class ViewBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewBuilder extends Builder
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
            'parent' => null,

            'assets' => [],

            'component' => 'view',

            'view' => View::class,

            'workflows' => [
                'build' => BuildComponent::class,
            ],
        ], $attributes));
    }
}
