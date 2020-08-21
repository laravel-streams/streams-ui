<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class BuildActions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildActions
{

    public function handle(FormBuilder $builder)
    {
        if ($builder->actions === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'actions');

        (new $workflow)->setAttribute('name', 'build_actions')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'actions',
        ]);
    }
}
