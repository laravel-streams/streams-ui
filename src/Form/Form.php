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
use Streams\Core\Support\Facades\Resolver;
use Streams\Ui\Form\Field\FieldCollection;
use Streams\Core\Support\Facades\Evaluator;
use Illuminate\Contracts\Validation\Factory;
use Streams\Ui\Form\Action\ActionCollection;
use Streams\Ui\Support\Traits\HasRepository;
use Illuminate\Contracts\Validation\Validator;

class Form extends Component
{

    use HasRepository;

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
    }

    public function query()
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

            $this->entry = $this->entry;

            return;
        }

        /*
         * Fallback to using the repository
         * to get and/or paginate the results.
         */
        if ($this->repository() instanceof Repository) {

            $this->criteria = $this->repository()->newCriteria();

            $this->entry = $this->criteria->find($this->entry);

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
