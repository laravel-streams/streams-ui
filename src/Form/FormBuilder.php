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
use Streams\Core\Support\Facades\Resolver;
use Streams\Ui\Form\Component\Field\Field;
use Streams\Core\Support\Facades\Evaluator;
use Streams\Ui\Form\Component\Action\Action;
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
        $fields = Normalizer::fillWithAttribute($fields, 'name', 'handle');

        $collection->each(function ($field) use ($fields) {

            if ($this->entry) {
                $field->input()->setPrototypeAttribute('value', $this->entry->{$field->handle});
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
        $this->make();

        if ($this->instance->actions->isNotEmpty()) {
            return $this->instance->actions;
        }

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

        return $this->instance->actions;
    }

    public function makeButtons()
    {
        $this->make();

        if ($this->instance->buttons->isNotEmpty()) {
            return $this->instance->buttons;
        }

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

        return $this->instance->buttons;
    }
}
