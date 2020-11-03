<?php

namespace Streams\Ui\Table\Component\View\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\MergeComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\Table\Component\View\Workflows\Views\DefaultViews;
use Streams\Ui\Table\Component\View\Workflows\Views\SetActiveView;
use Streams\Ui\Table\Component\View\Workflows\Views\NormalizeViews;
use Streams\Ui\Table\Component\View\Workflows\Views\ApplyActiveView;

/**
 * Class BuildViews
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildViews extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        //'resolve_views' => ResolveComponents::class,

        DefaultViews::class,
        NormalizeViews::class,

        'merge_views' => MergeComponents::class,

        //'translate_views' => TranslateComponents::class,
        //'parse_views' => ParseComponents::class,

        'build_views' => BuildComponents::class,

        SetActiveView::class,
        ApplyActiveView::class,
    ];
}
