<?php

namespace Anomaly\Streams\Ui\Table\Component\Button;

use Anomaly\Streams\Ui\Button\Button;
use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponent;

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
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'button',

        'button' => Button::class,

        'workflows' =>[
            'build' => BuildComponent::class,
        ],
    ];
}
