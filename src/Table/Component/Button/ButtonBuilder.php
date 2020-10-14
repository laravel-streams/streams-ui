<?php

namespace Streams\Ui\Table\Component\Button;

use Streams\Ui\Button\Button;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Workflows\BuildComponent;

/**
 * Class ButtonBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonBuilder extends Builder
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
    
            'component' => 'button',
    
            'button' => Button::class,
    
            'workflows' =>[
                'build' => BuildComponent::class,
            ],
        ], $attributes));
    }
}
