<?php

namespace Streams\Ui\Form;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Collective\Html\FormFacade;
use Streams\Ui\Support\Component;
use Streams\Core\Support\Workflow;
use Streams\Ui\Form\Action\Action;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Streams\Core\Repository\Repository;
use Streams\Ui\Button\ButtonCollection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Streams\Ui\Form\Action\Handler\Save;
use Streams\Core\Support\Facades\Messages;
use Streams\Ui\Form\Field\FieldCollection;
use Illuminate\Contracts\Validation\Factory;
use Streams\Ui\Form\Action\ActionCollection;
use Illuminate\Contracts\Validation\Validator;

/**
 *
 * @typescript
 * @property \Illuminate\Support\Collection $values
 * @property \Illuminate\Support\Collection $options
 * @property \Illuminate\Support\Collection $rules
 * @property \Illuminate\Support\Collection $validators
 * @property array $errors
 * @property \Illuminate\Support\Collection $sections
 * @property \Streams\Ui\Form\Field\FieldCollection|\Streams\Core\Field\FieldType[] $fields
 * @property \Streams\Ui\Form\Action\ActionCollection|\Streams\Ui\Form\Action\Action[] $actions
 * @property \Streams\Ui\Button\ButtonCollection|\Streams\Ui\Button\Button[] $buttons
 */
class Form extends Component
{

    protected function initializeComponentPrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'values' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'options' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],

            'rules' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'validators' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],

            'errors' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
                // 'config' => [
                //     'abstract' => MessageBag::class,
                // ],
            ],
            'fields' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => FieldCollection::class,
                ],
            ],
            'actions' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ActionCollection::class,
                ],
            ],
            'buttons' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ButtonCollection::class,
                ],
            ],
            'sections' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
        ]);

        return parent::loadPrototypeAttributes(array_merge([
            'component' => 'form',
            'template' => 'ui::forms.form',

            'stream' => null,
            'repository' => null,

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

            array_walk($rules, function (&$rule) use ($field) {

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
            });

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

        // @todo Tmp
        $handler = $this->handler ?: ($active->handler ?: Save::class);

        if (is_string($handler) && !Str::contains($handler, '@')) {
            $handler .= '@handle';
        }

        if (is_string($handler) || $handler instanceof \Closure) {
            App::call($handler, [
                'form' => $this,
            ]);
        }

        if (Request::expectsJson()) {
            $this->response = Response::json([
                'data' => null,
                'meta' => [
                    // 'parameters' => Request::route()->parameters(),
                    // 'query' => Request::query(),
                ],
                'links' => [
                    // 'self' => URL::to(Request::path()),
                    // 'index' => URL::route('ls.api.entries.index', ['stream' => $stream]),
                ],
                'errors' => [
                    //"Action [view] authorized for [{$stream}]."
                ]
                ], 200);
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



    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');

        //$this->authorize($attributes);
return;// @todo hrmm
        $this->makeFields($attributes);
        // $this->makeActions($attributes);
        // $this->makeButtons($attributes);

        $attributes['rules'] = array_merge(Arr::get($attributes, 'rules', []), $attributes['stream']->rules);
        $attributes['validators'] = array_merge(Arr::get($attributes, 'validators', []), $attributes['stream']->validators);

        $callbackData->put('attributes', $attributes);
    }

    public function onInitialized()
    {
        $this->query();

        if ($this->entry) {
            $this->fields->each(function ($field) {
                $field->type()->setPrototypeAttribute('value', $this->entry->{$field->handle});
                $field->input()->load($this->entry->{$field->handle});
            });
        }

        $this->initializeComponentPrototype([]);
    }

    public function query()
    {

        /**
         * If the builder already has
         * an entry then just use that.
         */
        if ($this->entry && is_object($this->entry)) {

            $this->entry = $this->entry;

            return;
        }

        /*
         * Fallback to using the repository
         * to get and/or paginate the results.
         */
        if ($this->entry && $this->repository() instanceof Repository) {

            $this->entry = $this->repository()->find($this->entry);

            return;
        }
    }

    public function authorize()
    {

        /**
         * Configured policy options
         * take precedense over the
         * model policy.
         */
        $policy = $this->options->get('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         *
         * @todo Use stream here instead
         */
        $model = null; //$this->model;

        if ($model && !Gate::allows($this->entry ? 'edit' : 'create', $model)) {
            abort(403);
        }
    }

    public function makeFields(&$attributes)
    {
        $fields = $attributes['stream']->fields;

        $attributes['fields'] = Arr::undot(Arr::get($attributes, 'fields', []));

        foreach ($attributes['fields'] as $key => $field) {
            if (Arr::get($field, 'enabled') === false) {
                $fields->forget($key);
            }
        }

        $fields->each(function ($field) use ($attributes) {

            if ($this->entry) {
                $field->input()->load($this->entry->{$field->handle});
            }

            if ($extra = Arr::get($attributes, 'fields.' . $field->handle, [])) {
                $field->loadPrototypeAttributes($extra);
            }
        });

        return $this->fields = $attributes['fields'] = $fields;
    }

    public function setActionsAttribute($actions)
    {
        $actions = $actions ?: ['save' => []];

        /**
         * Minimal standardization
         */
        array_walk($actions, function (&$action, $key) {

            $action = is_string($action) ? [
                'action' => $action,
            ] : $action;

            $action['handle'] = Arr::get($action, 'handle', $key);

            $action['stream'] = $this->stream;

            $action = new Action($action);
        });

        return $this->setPrototypeAttributeValue('actions', new ActionCollection($actions));
    }

    public function makeButtons(&$attributes)
    {
        $buttons = $attributes['buttons'] ?: ['cancel'];

        /**
         * Minimal standardization
         */
        array_walk($buttons, function (&$button, $key) {

            $button = is_string($button) ? [
                'button' => $button,
            ] : $button;

            $button['handle'] = Arr::get($button, 'handle', $key);

            $button['stream'] = $this->stream;

            $button = new Button($button);
        });

        return $this->instance->buttons = $this->buttons = new ButtonCollection($buttons);
    }
}
