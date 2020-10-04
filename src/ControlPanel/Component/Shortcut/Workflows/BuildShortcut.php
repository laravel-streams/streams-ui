<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Shortcut\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\ExpandShortcut;
use Anomaly\Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\DefaultShortcut;
use Anomaly\Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\NormalizeShortcut;

/**
 * Class BuildShortcut
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildShortcut extends Workflow
{
    protected $steps = [
        'resolve_navigation' => ResolveComponents::class,

        DefaultShortcut::class,
        NormalizeShortcut::class,
        ExpandShortcut::class,
        
        'translate_navigation' => TranslateComponents::class,
        'parse_navigation' => ParseComponents::class,

        'build_navigation' => BuildComponents::class,
    ];
}
