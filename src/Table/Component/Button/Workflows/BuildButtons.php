<?php

namespace Streams\Ui\Table\Component\Button\Workflows;

use Illuminate\Support\Str;
use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\MergeComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\Table\Component\Button\Workflows\Buttons\ExpandButtons;
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
        //'resolve_buttons' => ResolveComponents::class,

        DefaultButtons::class,
        'Streams\Ui\Table\Component\Button\Workflows\BuildButtons@normalize',
        'Streams\Ui\Table\Component\Button\Workflows\BuildButtons@expand',

        'merge_buttons' => MergeComponents::class,
        //'translate_buttons' => TranslateComponents::class,

        /**
         * Don't do these things because it
         * depends on the entry data per row.
         */
        //'parse_buttons' => ParseComponents::class,

        'build_buttons' => BuildComponents::class,
    ];

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function normalize(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        $buttons = Normalizer::normalize($buttons);

        $buttons = Normalizer::fillWithKey($buttons, 'handle');
        $buttons = Normalizer::fillWithKey($buttons, 'button');

        $buttons = Normalizer::attributes($buttons);

        $builder->buttons = $buttons;
    }

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function expand(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        foreach ($buttons as &$button) {

            if (!isset($button['attributes']['href']) && isset($button['button']) && Str::startsWith($button['button'], ['edit'])) {
                $button['attributes']['href'] = 'cp/{request.segments.1}/update/{entry.id}';
            }
        }

        $builder->buttons = $buttons;
    }
}
