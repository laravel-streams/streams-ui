<?php

namespace Streams\Ui\Table\Component\Button\Workflows\Buttons;

use Illuminate\Support\Str;
use Streams\Ui\Table\TableBuilder;

class ExpandButtons
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
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
