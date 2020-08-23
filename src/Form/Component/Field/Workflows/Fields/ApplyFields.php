<?php

namespace Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields;

use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class ApplyFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ApplyFields
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $builder->instance->fields->each(function($field) {
            
            $field->field = $field->stream_field;

            unset($field->stream_field);
        });
    }
}
