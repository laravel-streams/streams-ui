<?php

namespace Streams\Ui\Form\Component\Field;

use Streams\Ui\Support\Builder;
use Streams\Ui\Form\Component\Field\Field;
use Streams\Ui\Support\Workflows\BuildComponent;

/**
 * Class FieldTypeBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldBuilder extends Builder
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

            'component' => 'field',

            'field' => Field::class,

            'workflows' => [
                'build' => BuildComponent::class,
            ],
        ], $attributes));
    }
}
