<?php

namespace Anomaly\Streams\Ui\Form\Component\Field\Workflows\Sections;

use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class PopulateSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PopulateSections
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!$entry = $builder->instance->entry) {
            return;
        }

        $builder->instance->fields->each(function($field) use ($entry) {
            $field->type()->value = $entry->{$field->handle};
        });
    }
}
