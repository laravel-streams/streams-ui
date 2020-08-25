<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Ui\Form\FormAuthorizer;

/**
 * Class SetValidation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetValidation
{

    /**
     * Handle the command.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        $rules = array_merge(
            (array) $builder->rules,
            (array) $builder->stream->rules
        );

        $validators = array_merge(
            (array) $builder->validators,
            (array) $builder->stream->validators
        );

        $builder->instance->rules = $builder->rules = $rules;
        $builder->instance->validators = $builder->validators = $validators;
    }
}
