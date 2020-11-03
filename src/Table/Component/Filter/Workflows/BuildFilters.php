<?php

namespace Streams\Ui\Table\Component\Filter\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\MergeComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\Table\Component\Filter\Workflows\Filters\ExpandFilters;
use Streams\Ui\Table\Component\Filter\Workflows\Filters\DefaultFilters;
use Streams\Ui\Table\Component\Filter\Workflows\Filters\SetActiveFilter;
use Streams\Ui\Table\Component\Filter\Workflows\Filters\NormalizeFilters;

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
        //'resolve_filters' => ResolveComponents::class,

        DefaultFilters::class,
        NormalizeFilters::class,
        ExpandFilters::class,

        'merge_filters' => MergeComponents::class,

        //'translate_filters' => TranslateComponents::class,
        //'parse_filters' => ParseComponents::class,

        'build_filters' => BuildComponents::class,

        SetActiveFilter::class,
    ];
}
