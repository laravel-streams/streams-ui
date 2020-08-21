<?php

namespace Anomaly\Streams\Ui\Form\Component\Action;

use Anomaly\Streams\Ui\Support\Builder;
use Anomaly\Streams\Ui\Form\Component\Action\Action;
use Anomaly\Streams\Ui\Support\Workflows\BuildWorkflow;

/**
 * Class ActionBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'action',

        'action' => Action::class,
        
        'workflows' => [
            'build' => BuildWorkflow::class,
        ],
    ];
}
