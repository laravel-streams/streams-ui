<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\ExpandShortcut;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\DefaultShortcut;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\NormalizeShortcut;

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
