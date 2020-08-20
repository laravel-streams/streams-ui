<?php

namespace Anomaly\Streams\Ui\Form\Component\Action\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\MergeComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Form\Component\Action\Workflows\Actions\DefaultActions;
use Anomaly\Streams\Ui\Form\Component\Action\Workflows\Actions\SetActiveAction;
use Anomaly\Streams\Ui\Form\Component\Action\Workflows\Actions\NormalizeActions;

/**
 * Class ActionsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_actions' => ResolveComponents::class,

        DefaultActions::class,
        NormalizeActions::class,

        'merge_actions' => MergeComponents::class,

        'translate_actions' => TranslateComponents::class,
        'parse_actions' => ParseComponents::class,

        'build_actions' => BuildComponents::class,

        SetActiveAction::class,
    ];
}
