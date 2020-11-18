<?php

namespace Streams\Ui\Form;

use Illuminate\Support\Arr;
use Collective\Html\FormFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\MessageBag;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Button\ButtonCollection;
use Streams\Core\Support\Facades\Messages;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Streams\Ui\Form\Component\Field\FieldCollection;
use Streams\Ui\Form\Component\Action\ActionCollection;
use Streams\Ui\Form\Component\Section\SectionCollection;

/**
 * Class Form
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Form extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'values' => [
                'type' => 'collection',
            ],
            'options' => [
                'type' => 'collection',
            ],

            'rules' => [
                'type' => 'collection',
            ],
            'validators' => [
                'type' => 'collection',
            ],

            'errors' => [
                //'type' => 'collection',
                // 'config' => [
                //     'abstract' => MessageBag::class,
                // ],
            ],
            'fields' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => FieldCollection::class,
                ],
            ],
            'actions' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ActionCollection::class,
                ],
            ],
            'buttons' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ButtonCollection::class,
                ],
            ],
            'sections' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => SectionCollection::class,
                ],
            ],
        ]);

        return parent::initializePrototype(array_merge([
            'component' => 'form',
            'template' => 'ui::forms.form',

            'mode' => null,
            'entry' => null,

            //'handler' => FormHandler::class, // Action sets this

            'errors' => [],

            'values' => [],
            'options' => [],

            'rules' => [],
            'validators' => [],

            'fields' => [],
            'actions' => [],
            'buttons' => [],
            'sections' => [],
        ], $attributes));
    }

    /**
     * Return the opening form tag.
     *
     * @param  array $options
     * @return string
     */
    public function open(array $options = [])
    {
        if ($url = $this->options->get('url')) {
            $options['url'] = $url;
        } else {
            $options['url'] = Request::fullUrl();
        }

        $options['files'] = true; // multipart/form-data

        return FormFacade::open($options);
    }

    /**
     * Return the closing form tag.
     *
     * @return string
     */
    public function close()
    {
        return FormFacade::close();
    }

    public function post()
    {
        $workflow = (new Workflow([
            'load' => [$this, 'load'],
            'validate' => [$this, 'validate'],
            'handle' => [$this, 'handle'],
        ]))->passThrough($this);

        $this->fire('posting', [
            'form' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process([
            'form' => $this,
            'workflow' => $workflow
        ]);

        $this->fire('posted', [
            'form' => $this
        ]);

        return $this;
    }

    public function load()
    {
        // @todo foreach meta fields? ID should be a field.. - marked meta?
        if ($id = $this->request('id')) {
            $this->values->put('id', $id);
        }

        foreach ($this->fields as $field) {
            $this->values->put($field->handle, $this->request($field->handle));
        }
    }

    public function validate(Factory $factory)
    {
        $values = $this->values->all();

        $rules = $this->rules->map(function ($rules) {
            return implode('|', array_unique($rules));
        })->all();

        if (!$this->validator && $this->stream) {
            $this->validator = $this->stream
                ->validator($values);

            $this->validator->addRules($rules);
        }

        // @todo test this
        if (!$this->validator && !$this->stream) {
            $this->validator = $factory->make($values, $rules);
        }

        $this->extendValidation($this, $factory);

        $this->errors = $this->validator->messages();

        if (!$this->errors->isEmpty()) {
            Messages::success('You win!');
        }

        if ($this->errors->isNotEmpty()) {
            foreach ($this->errors->messages() as $errors) {
                Messages::error(implode("\n\r", $errors));
            }
        }
    }

    public function handle()
    {
        App::call($this->handler, [
            'form' => $this,
        ]);

        $this->response = redirect(request()->fullUrl());
    }

    public function getHandlerAttribute()
    {
        return function ($form) {

            if ($this->errors->isNotEmpty()) {
                return;
            }

            $entry = $form->entry ?: $form->stream->repository()->newInstance();

            foreach ($form->values as $field => $value) {
                $entry->{$field} = $value;
            }

            $form->stream->repository()->save($entry);

            $form->entry = $form->entry = $entry;
        };
    }

    protected function extendValidation(Form $form, Factory $factory): void
    {
        foreach ($form->validators as $rule => $validator) {

            $handler = Arr::get($validator, 'handler');

            $factory->extend(
                $rule,
                $this->callback($handler, $form),
                Arr::get($validator, 'message')
            );
        }
    }

    protected function callback($handler, Form $form): \Closure
    {
        return function ($attribute, $value, $parameters, Validator $validator) use ($handler, $form) {

            $field = $form->fields->get($attribute);

            App::call(
                $handler,
                [
                    'form' => $form,
                    'value' => $value,
                    'field' => $field,
                    'attribute' => $attribute,
                    'validator' => $validator,
                    'parameters' => $parameters,
                ],
                'handle'
            );
        };
    }
}
