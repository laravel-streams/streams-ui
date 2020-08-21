<?php

namespace Anomaly\Streams\Ui\Form\Component\Field;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Platform\Field\Field;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\BuildFields;

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
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'field',

        'field' => Field::class,
        
        'workflows' => [
            'build' => BuildFields::class,
        ],
    ];
}
