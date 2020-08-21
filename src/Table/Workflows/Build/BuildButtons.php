<?php

namespace Anomaly\Streams\Ui\Table\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Table\Component\Button\Workflows\ButtonsWorkflow;

/**
 * Class BuildButtons
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildButtons
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->buttons === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'buttons');

        (new $workflow)->setAttribute('name', 'build_buttons')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'buttons',
        ]);
    }
}
