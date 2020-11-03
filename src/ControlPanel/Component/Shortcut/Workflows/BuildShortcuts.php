<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\LoadShortcuts;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\ExpandShortcuts;
use Streams\Ui\ControlPanel\Component\Shortcut\Workflows\Build\NormalizeShortcuts;

/**
 * Class BuildShortcuts
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildShortcuts extends Workflow
{
    protected $steps = [
        //'resolve_shortcuts' => ResolveComponents::class,

        LoadShortcuts::class,
        NormalizeShortcuts::class,
        ExpandShortcuts::class,
        
        //'translate_shortcuts' => TranslateComponents::class,
        //'parse_shortcuts' => ParseComponents::class,

        'build_shortcuts' => BuildComponents::class,
    ];
}
