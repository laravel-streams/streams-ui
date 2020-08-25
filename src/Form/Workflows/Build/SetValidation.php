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

        foreach ($builder->stream->fields as $key => $field) {

            if ($field->rules) {
                $rules[$key] = $field->rules;
            }

            if ($field->validators) {
                $validators[$key] = $field->validators;
            }
        }

        $builder->instance->rules = $builder->rules = $rules;
        $builder->instance->validators = $builder->validators = $validators;
    }
}
