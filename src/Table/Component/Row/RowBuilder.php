<?php

namespace Anomaly\Streams\Ui\Table\Component\Row;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponent;

/**
 * Class RowBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowBuilder extends Builder
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
            'entry' => null,
            'parent' => null,

            'assets' => [],

            'component' => 'row',

            'row' => Row::class,

            'workflows' => [
                'build' => BuildComponent::class,
            ],
        ], $attributes));
    }
}
