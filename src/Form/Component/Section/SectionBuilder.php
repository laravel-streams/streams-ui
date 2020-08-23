<?php

namespace Anomaly\Streams\Ui\Form\Component\Section;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponent;
use Anomaly\Streams\Ui\ControlPanel\Component\Section\Section;

/**
 * Class SectionBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'section',

        'section' => Section::class,
        
        'workflows' => [
            'build' => BuildComponent::class,
        ],
    ];
}
