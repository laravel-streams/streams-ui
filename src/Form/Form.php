<?php

namespace Streams\Ui\Form;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\FormFacade;
use Streams\Ui\Support\Component;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Button\ButtonCollection;
use Illuminate\Support\Facades\Redirect;
use Streams\Core\Support\Facades\Messages;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Streams\Ui\Form\Field\FieldCollection;
use Streams\Ui\Form\Action\ActionCollection;


class Form extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
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
            ],
        ]);

        return parent::initializePrototypeAttributes(array_merge([
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
        $keyName = $this->stream->config('key_name', 'id');

        $options['url'] = $this->options->get('url') ?: ($this->url() . ($this->entry ? '?entry=' . $this->entry->{$keyName} : null));

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
            'detect' => [$this, 'detect'],
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
        $keyName = $this->stream->config('key_name', 'id');

        if ($key = $this->request($keyName)) {
            $this->values->put($keyName, $key);
        }

        foreach ($this->fields as $field) {
            $this->values->put($field->handle, $field->input()->post()->value());
        }
    }

    public function validate(Factory $factory)
    {
        $values = $this->values->all();

        $rules = $this->rules->map(function ($rules, $field) {

            array_map(function (&$rule) use ($field) {

                if (Str::startsWith($rule, 'unique')) {

                    // @todo get prefixes are dumb
                    $parameters = $this->stream->ruleParameters($field, 'unique');

                    if (!$parameters) {
                        $parameters[] = $this->stream->handle;
                    }

                    if (count($parameters) === 1) {
                        $parameters[] = $field;
                    }

                    if (count($parameters) === 2 && $this->entry && $ignore = $this->entry->{$field}) {
                        $parameters[] = $ignore;
                        $parameters[] = $field;
                    }

                    $rule = 'unique:' . implode(',', $parameters);
                }
            }, $rules);

            return implode('|', array_unique($rules));
        })->all();

        if (!$this->validator && $this->stream) {

            $this->validator = $this->stream
                ->validator($values);

            if ($rules) {
                $this->validator->setRules($rules);
            }
        }

        // @todo test this
        if (!$this->validator && !$this->stream) {
            $this->validator = $factory->make($values, $rules);
        }

        $this->extendValidation($this, $factory);

        $this->errors = $this->validator->messages();

        if ($this->errors->isEmpty()) {
            Messages::success(trans('ui::messages.save_success')); // @todo success! configure..
        }

        if ($this->errors->isNotEmpty()) {
            
            foreach ($this->errors->messages() as $errors) {
                Messages::error(implode("\n\r", $errors));
            }

            $this->response = Redirect::back()->with('messages', Messages::get());
        }
    }

    public function detect()
    {
        if ($this->actions->active()) {
            return;
        }

        if ($action = $this->actions->get($this->request('action'))) {
            $action->active = true;
        }
    }

    public function handle()
    {
        if ($this->response) {
            return;
        }

        $active = $this->actions->active();

        $handler = $this->handler ?: $active->handler;

        if (is_string($handler) && !Str::contains($handler, '@')) {
            $handler .= '@handle';
        }

        if (is_string($handler) || $handler instanceof \Closure) {
            App::call($handler, [
                'form' => $this,
            ]);
        }

        $this->response ?: $this->response = Redirect::back()->with('messages', Messages::get());
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
