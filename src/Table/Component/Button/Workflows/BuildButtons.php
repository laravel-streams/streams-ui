<?php

namespace Streams\Ui\Table\Component\Button\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\MergeComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\Table\Component\Button\Workflows\Buttons\DefaultButtons;
use Streams\Ui\Table\Component\Button\Workflows\Buttons\NormalizeButtons;

/**
 * Class BuildButtons
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildButtons extends Workflow
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
        
        /**
         * Don't do these things because it
         * depends on the entry data per row.
         */
        //'translate_buttons' => TranslateComponents::class,
        //'parse_buttons' => ParseComponents::class,

        'build_buttons' => BuildComponents::class,
    ];
}
