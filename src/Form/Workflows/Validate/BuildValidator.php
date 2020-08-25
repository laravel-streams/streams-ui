<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Validate;

use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use Anomaly\Streams\Ui\Form\FormBuilder;

/**
 * Class BuildValidator
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildValidator
{
    public function handle(FormBuilder $builder, Factory $factory): void
    {
        $this->extendValidation($builder, $factory);

        $builder->validator = $factory->make(
            $builder->instance->values->all(),
            $builder->instance->rules->map(function($rules) {
                return implode('|', array_unique($rules));
            })->all()
        );
    }

    protected function extendValidation(FormBuilder $builder, Factory $factory): void
    {
        foreach ($builder->instance->validators as $rule => $validator) {

            $handler = Arr::get($validator, 'handler');

            $factory->extend($rule, $this->callback($handler, $builder),
                Arr::get($validator, 'message')
            );
        }
    }

    protected function callback($handler, FormBuilder $builder): \Closure
    {
        return function ($attribute, $value, $parameters, Validator $validator) use ($handler, $builder) {

            $field = $builder->instance->fields->get($attribute);

            App::call(
                $handler,
                [
                    'value' => $value,
                    'field' => $field,
                    'builder' => $builder,
                    'attribute' => $attribute,
                    'validator' => $validator,
                    'parameters' => $parameters,
                ],
                'handle'
            );
        };
    }
}
