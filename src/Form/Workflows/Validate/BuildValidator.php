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
    public function handle(FormBuilder $builder, Factory $factory)
    {
        $this->extendValidation($builder, $factory);
        //$this->extendMessages($builder, $factory);

        $builder->validator = $factory->make(
            $builder->instance->values->all(),
            $builder->instance->rules->map(function($rules) {
                return implode('|', $rules);
            })->all()
        );
    }

    protected function extendValidation(FormBuilder $builder, Factory $factory)
    {
        foreach ($builder->instance->validators as $rule => $validator) {

            $handler = Arr::get($validator, 'handler');

            $factory->extend($rule, $this->callback($handler, $builder),
                Arr::get($validator, 'message')
            );
        }
    }

    /**
     * Return the validating callback.
     *
     * @param string $handler
     * @param FormBuilder $builder
     */
    protected function callback($handler, FormBuilder $builder)
    {
        return function ($attribute, $value, $parameters, Validator $validator) use ($handler, $builder) {

            if ($prefix = $builder->instance->options->get('prefix')) {
                $attribute = preg_replace("/^{$prefix}/", '', $attribute, 1);
            }

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

    private function extendMessages(FormBuilder $builder, Factory $factory)
    {
        // $messages = [];

        // foreach ($builder->instance->fields as $field) {
        //     foreach ($field->validators as $rule => $validator) {
        //         if ($message = Arr::get($validator, 'message')) {
        //             $messages[$field->getPrefix() . $field->getField() . '.' . $rule] = $message;
        //         }
        //     }

        //     foreach ($field->getMessages() as $rule => $message) {
        //         if ($message && Str::contains($message, '::')) {
        //             $message = trans($message);
        //         }

        //         $messages[$field->getPrefix() . $field->getField() . '.' . $rule] = $message;
        //     }
        // }

        // return $messages;
    }
}
