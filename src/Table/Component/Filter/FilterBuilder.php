<?php

namespace Anomaly\Streams\Ui\Table\Component\Filter;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponent;

/**
 * Class FilterBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FilterBuilder extends Builder
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
    
            'component' => 'filter',
    
            'filter' => Filter::class,
    
            'workflows' => [
                'build' => BuildComponent::class,
            ],
        ], $attributes));
    }
}
