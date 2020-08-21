<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\FieldsWorkflow;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\DefaultFields;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\PopulateFields;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\NormalizeFields;

/**
 * Class BuildFields
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFields
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->fields === false) {
            return;
        }

        $workflow = Arr::get($builder->workflows, 'fields');

        (new $workflow)->setAttribute('name', 'build_fields')->passThrough($builder)->process([
            'builder' => $builder,
            'component' => 'fields',
        ]);
    }
}
