<?php

namespace Streams\Ui\Form;

use Streams\Ui\Form\Form;
use Illuminate\Support\Arr;
use Streams\Ui\Button\Button;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Normalizer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Resolver;
use Streams\Ui\Form\Component\Field\Field;
use Streams\Core\Support\Facades\Evaluator;
use Illuminate\Contracts\Validation\Factory;
use Streams\Ui\Form\Component\Action\Action;
use Illuminate\Contracts\Validation\Validator;
use Streams\Ui\Form\Component\Action\ActionRegistry;
use Streams\Ui\Form\Component\Button\ButtonRegistry;
use Streams\Core\Repository\Contract\RepositoryInterface;

/**
 * Class FormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormBuilder extends Builder
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'async' => false,
            'handler' => null,
            'read_only' => false,

            'stream' => null,
            'repository' => null,

            'entry' => null,

            'rules' => [],
            'validators' => [],

            'fields' => [],
            'assets' => [],
            'actions' => [],
            'buttons' => [],
            'sections' => [],

            'options' => [],

            'component' => 'form',
            'form' => Form::class,

            'steps' => [
                'make_component' => [$this, 'make'],

                'query_entry' => [$this, 'queryEntry'],

                'authorize_form' => [$this, 'authorizeForm'],

                'set_validation' => [$this, 'setValidation'],

                'make_fields' => [$this, 'makeFields'],
                'load_fields' => [$this, 'loadFields'],

                'make_actions' => [$this, 'makeActions'],
                'make_buttons' => [$this, 'makeButtons'],
                
                'load_values' => [$this, 'loadValues'],
                'validate_form' => [$this, 'validateForm'],
            ],
        ], $attributes));
    }

    public function getHandlerAttribute()
    {
        return function ($builder) {

            $entry = $builder->instance->entry;

            foreach ($builder->instance->values as $field => $value) {
                $entry->{$field} = $value;
            }

            $builder->instance->stream->repository()->save($entry);

            $builder->entry = $builder->instance->entry = $entry;
        };
    }

    public function repository()
    {
        if ($this->repository instanceof RepositoryInterface) {
            return $this->repository;
        }

        /**
         * Default to configured.
         */
        if ($this->repository) {
            return $this->repository = App::make($this->repository, [
                'builder' => $this,
            ]);
        }

        /**
         * Fallback for Streams.
         */
        if (!$this->repository && $this->stream instanceof Stream) {
            return $this->repository = $this->stream->repository();
        }

        return null;
    }

    public function validate(): Builder
    {
        $workflow = $this->workflow('validate');

        $this->fire('validating', [
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process([
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $this->fire('validated', ['builder' => $this]);

        return $this;
    }

    public function queryEntry()
    {
        /*
         * If the builder has an entry handler
         * then call it through the container and
         * let it load the entry itself.
         */
        if (
            (is_string($this->entry) && class_exists($this->entry))
            || $this->entry instanceof \Closure
        ) {

            $entry = Resolver::resolve($this->entry, compact('builder'));

            $this->entry = Evaluator::evaluate($entry ?: $this->entry, compact('builder'));

            return;
        }

        /**
         * If the builder already has
         * an entry then just use that.
         */
        if ($this->entry && is_object($this->entry)) {

            $this->instance->entry = $this->entry;

            return;
        }

        /*
         * Fallback to using the repository 
         * to get and/or paginate the results.
         */
        if ($this->repository() instanceof RepositoryInterface) {

            $this->criteria = $this->repository()->newCriteria();

            $this->instance->entry = $this->criteria->find($this->entry);

            return;
        }
    }

    public function authorizeForm(FormAuthorizer $authorizer)
    {
        $authorizer->authorize($this);
    }

    public function setValidation()
    {
        if (!$this->stream) {
            return;
        }

        $rules = array_merge(
            (array) $this->rules,
            (array) $this->stream->rules
        );

        $validators = array_merge(
            (array) $this->validators,
            (array) $this->stream->validators
        );

        $this->instance->rules = $this->rules = $rules;
        $this->instance->validators = $this->validators = $validators;
    }

    public function makeFields()
    {
        $fields = $this->fields;

        if ($this->stream) {
            $fields = $this->stream->fields->toArray();
        }

        $fields = Normalizer::normalize($fields, 'type');
        $fields = Normalizer::fillWithKey($fields, 'handle');

        foreach ($fields as &$input) {

            $input['rules'] = array_map(function ($rules) {

                if (is_string($rules)) {
                    return explode('|', $rules);
                }

                return $rules;
            }, Arr::get($input, 'rules', []));

            if (strpos($input['type'], '|')) {
                list($input['type'], $input['input']) = explode('|', $input['type']);
            } else {
                $input['input'] = $input['type'];
            }
        }

        $this->loadInstanceWith('fields', $fields, Field::class);

        $this->fields = $fields;
    }

    public function loadFields()
    {
        if (!$entry = $this->instance->entry) {
            return;
        }

        $this->instance->fields->each(function($field) use ($entry) {
            $field->value = $entry->{$field->handle} ?? null;
        });
    }

    public function makeActions()
    {
        $actions = $this->actions;

        if (!$actions) {
            $actions = [
                'save',
            ];
        }

        $actions = Normalizer::normalize($actions, 'action');
        $actions = Normalizer::fillWithKey($actions, 'handle');

        $registry = app(ActionRegistry::class);

        foreach ($actions as &$attributes) {
            if ($registered = $registry->get(Arr::pull($attributes, 'action'))) {
                $attributes = array_replace_recursive($registered, $attributes);
            }
        }

        $this->loadInstanceWith('actions', $actions, Action::class);

        $this->actions = $actions;
    }

    public function makeButtons()
    {
        $buttons = $this->buttons;
        $stream = $this->stream;

        if (!$buttons) {
            $buttons = [
                'cancel',
            ];
        }

        $buttons = Normalizer::normalize($buttons, 'button');
        $buttons = Normalizer::fillWithKey($buttons, 'handle');
        $buttons = Normalizer::fillWithKey($buttons, 'button');
        $buttons = Normalizer::attributes($buttons);

        foreach ($buttons as &$button) {

            /**
             * Default guesser for cancel button.
             */
            if ($button['button'] == 'cancel' && !isset($button['attributes']['href']) && $stream) {
                $button['attributes']['href'] = URL::route('ui::cp.index', ['stream' => $stream->handle]);
            }
        }

        $registry = app(ButtonRegistry::class);

        foreach ($buttons as &$attributes) {
            if ($registered = $registry->get(Arr::pull($attributes, 'button'))) {
                $attributes = array_replace_recursive($registered, $attributes);
            }
        }

        $this->loadInstanceWith('buttons', $buttons, Button::class);

        $this->buttons = $buttons;
    }

    public function loadValues()
    {
        if (!Request::is('post')) {
            return;
        }

        foreach ($this->instance->fields as $field) {
            $this->instance->values->put($field->handle, $this->request($field->handle));
        }
    }

    public function validateForm(Factory $factory)
    {
        if ($this->instance->rules->isEmpty() && $this->instance->stream) {

            $this->validator = $this->instance->stream->validator($this->instance->values);

            return;
        }

        $this->extendValidation($this, $factory);

        $this->validator = $factory->make(
            $this->instance->values->all(),
            $this->instance->rules->map(function($rules) {
                return implode('|', array_unique($rules));
            })->all()
        );

        $this->instance->errors = $this->validator->messages();
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
