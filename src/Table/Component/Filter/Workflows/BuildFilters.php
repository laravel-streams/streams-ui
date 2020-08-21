<?php

namespace Anomaly\Streams\Ui\Table\Component\Filter\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\MergeComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Table\Component\Filter\Workflows\Filters\DefaultFilters;
use Anomaly\Streams\Ui\Table\Component\Filter\Workflows\Filters\SetActiveFilter;
use Anomaly\Streams\Ui\Table\Component\Filter\Workflows\Filters\NormalizeFilters;

/**
 * Class BuildFilters
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFilters extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_filters' => ResolveComponents::class,

        DefaultFilters::class,
        NormalizeFilters::class,

        'merge_filters' => MergeComponents::class,

        'translate_filters' => TranslateComponents::class,
        'parse_filters' => ParseComponents::class,

        'build_filters' => BuildComponents::class,

        SetActiveFilter::class,
    ];
}
