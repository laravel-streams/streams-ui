<?php

namespace Anomaly\Streams\Ui\Table\Component\Button\Workflows;

use Anomaly\Streams\Platform\Workflow\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\MergeComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Table\Component\Button\Workflows\Buttons\DefaultButtons;
use Anomaly\Streams\Ui\Table\Component\Button\Workflows\Buttons\NormalizeButtons;

/**
 * Class ButtonsWorkflow
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonsWorkflow extends Workflow
{

    /**
     * The build steps.
     *
     * @var array
     */
    protected $steps = [
        'resolve_buttons' => ResolveComponents::class,

        DefaultButtons::class,
        NormalizeButtons::class,

        'merge_buttons' => MergeComponents::class,

        'translate_buttons' => TranslateComponents::class,
        'parse_buttons' => ParseComponents::class,

        'build_buttons' => BuildComponents::class,
    ];
}
