<?php

namespace Streams\Ui\Form;

use Streams\Ui\Form\Form;
use Illuminate\Support\Arr;
use Streams\Ui\Button\Button;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Streams\Ui\Form\Action\Action;
use Streams\Ui\Support\Normalizer;
use Illuminate\Support\Facades\App;
use Streams\Ui\Form\FormAuthorizer;
use Streams\Core\Repository\Repository;
use Streams\Ui\Button\ButtonCollection;
use Streams\Core\Support\Facades\Resolver;
use Streams\Core\Support\Facades\Evaluator;
use Streams\Ui\Form\Action\ActionCollection;

class FormBuilder extends Builder
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
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

            'config' => [
                'auto_query' => true,
            ],

            'component' => 'form',
            'form' => Form::class,

            'steps' => [
                'make_form' => [$this, 'make'],
                'setup' => [$this, 'setup'],

                'query_entry' => [$this, 'queryEntry'],

                'authorize_form' => [$this, 'authorizeForm'],

                'set_validation' => [$this, 'setValidation'],

                'make_fields' => [$this, 'makeFields'],
                'make_actions' => [$this, 'makeActions'],
                'make_buttons' => [$this, 'makeButtons'],
            ],
        ], $attributes));
    }

    public function repository()
    {
        if ($this->repository instanceof Repository) {
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

    public function setup()
    {
        $this->instance->options = $this->options;
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
        if ($this->repository() instanceof Repository) {

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
        $this->instance->rules = $this->rules ?: $this->stream->rules;
        $this->instance->validators = $this->validators ?: $this->stream->validators;
    }

    public function makeFields()
    {
        $this->make();

        if ($this->instance->fields->isNotEmpty()) {
            return $this->instance->fields;
        }

        $fields = $this->fields;

        $collection = $this->stream->fields;

        $fields = Normalizer::normalize($fields, 'type');
        $fields = Normalizer::fillWithKey($fields, 'handle');

        $collection->each(function ($field) use ($fields) {

            if ($this->entry) {
                $field->input()->load($this->entry->{$field->handle});
            }

            if (!$extra = Arr::get($fields, $field->handle, [])) {
                return;
            }

            $field->loadPrototypeAttributes($extra);
        });

        $this->fields = $this->instance->fields = $collection;

        return $this->instance->fields;
    }

    public function makeActions()
    {
        $actions = $this->actions ?: ['save'];

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

        return $this->instance->actions = $this->actions = new ActionCollection($actions);
    }

    public function makeButtons()
    {
        $this->make();

        if ($this->instance->buttons->isNotEmpty()) {
            return $this->instance->buttons;
        }

        $buttons = $this->buttons ?: ['cancel'];

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
