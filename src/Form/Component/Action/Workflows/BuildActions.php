<?php

namespace Streams\Ui\Form\Component\Action\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\MergeComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\Form\Component\Action\Workflows\Build\DefaultActions;
use Streams\Ui\Form\Component\Action\Workflows\Build\SetActiveAction;
use Streams\Ui\Form\Component\Action\Workflows\Build\NormalizeActions;

/**
 * Class BuildActions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildActions extends Workflow
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
