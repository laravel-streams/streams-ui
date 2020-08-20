<?php

namespace Anomaly\Streams\Ui\Table\Component\View\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\MergeComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Table\Component\View\Workflows\Views\DefaultViews;
use Anomaly\Streams\Ui\Table\Component\View\Workflows\Views\SetActiveView;
use Anomaly\Streams\Ui\Table\Component\View\Workflows\Views\NormalizeViews;

/**
 * Class ViewsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_views' => ResolveComponents::class,

        DefaultViews::class,
        NormalizeViews::class,

        'merge_views' => MergeComponents::class,

        'translate_views' => TranslateComponents::class,
        'parse_views' => ParseComponents::class,

        'build_views' => BuildComponents::class,

        SetActiveView::class,
    ];
}
