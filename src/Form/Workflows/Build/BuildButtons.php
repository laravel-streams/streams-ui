<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class BuildButtons
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildButtons
{
    public function handle(FormBuilder $builder)
    {
        if ($builder->buttons === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'fields');

        (new $workflow)->setAttribute('name', 'build_buttons')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'buttons',
        ]);
    }
}
