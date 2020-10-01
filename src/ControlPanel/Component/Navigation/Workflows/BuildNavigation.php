<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build\GuessNavigation;
use Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build\DefaultNavigation;
use Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build\NormalizeNavigation;

/**
 * Class BuildNavigation
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildNavigation extends Workflow
{
    protected $steps = [
        'resolve_navigation' => ResolveComponents::class,

        DefaultNavigation::class,
        NormalizeNavigation::class,
        GuessNavigation::class,
        
        'translate_navigation' => TranslateComponents::class,
        'parse_navigation' => ParseComponents::class,

        'build_navigation' => BuildComponents::class,
    ];
}
