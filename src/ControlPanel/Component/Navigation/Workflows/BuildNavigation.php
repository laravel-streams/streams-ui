<?php

namespace Streams\Ui\ControlPanel\Component\Navigation\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build\LoadNavigation;
use Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build\ExpandNavigation;
use Streams\Ui\ControlPanel\Component\Navigation\Workflows\Build\NormalizeNavigation;

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

        LoadNavigation::class,
        NormalizeNavigation::class,
        ExpandNavigation::class,

        'translate_navigation' => TranslateComponents::class,
        'parse_navigation' => ParseComponents::class,

        'build_navigation' => BuildComponents::class,
    ];
}
