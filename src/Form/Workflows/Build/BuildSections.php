<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Ui\Form\Component\Section\SectionBuilder;

/**
 * Class BuildSections
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildSections
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->sections === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'sections');

        (new $workflow)->setAttribute('name', 'build_sections')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'sections',
        ]);
    }
}
