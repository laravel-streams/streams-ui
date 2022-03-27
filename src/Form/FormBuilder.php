<?php

namespace Streams\Ui\Form;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Value;
use Streams\Ui\Table\Row\Row;
use Streams\Ui\Support\Builder;
use Streams\Ui\Table\View\View;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Table\Action\Action;
use Streams\Ui\Table\Column\Column;
use Streams\Ui\Table\Filter\Filter;
use Streams\Ui\Table\View\ViewHandler;
use Illuminate\Support\Facades\Request;

class FormBuilder extends Builder
{
    public function process(array $payload = []): void
    {
        $this->addStep('load_entry', self::class . '@loadEntry');

        $this->addStep('make_fields', self::class . '@makeFields');
        // $this->addStep('load_fields', self::class . '@loadFields');

        // $this->addStep('make_actions', self::class . '@makeActions');
        // $this->addStep('make_buttons', self::class . '@makeButtons');

        // $this->addStep('merge_rules', self::class . '@makeRules');
        // $this->addStep('merge_validators', self::class . '@makeValidators');
        
        // $attributes['rules'] = array_merge(Arr::get($attributes, 'rules', []), $attributes['stream']->rules);
        // $attributes['validators'] = array_merge(Arr::get($attributes, 'validators', []), $attributes['stream']->validators);

        parent::process($payload);
    }

    public function loadEntry(Component $component)
    {
        if (!$component->entry) {
            return;
        }

        if (!$component->stream) {
            return;
        }

        $component->entry = $component->stream->repository()->find($component->entry);
    }

    public function makeFields(Component $component)
    {
        $component->fields = $component->fields->filter(fn ($field) => $field->enabled !== false);

        $component->fields = $component->fields->each(function ($field) {

            // if ($this->entry) {
            //     $field->input()->load($this->entry->{$field->handle});
            // }

            // if ($extra = Arr::get($attributes, 'fields.' . $field->handle, [])) {
            //     $field->loadPrototypeAttributes($extra);
            // }
        });

        $component->fields = $component->stream->fields;
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

        return $this->instance->buttons = $this->buttons = new Collection($buttons);
    }

    public function loadFields(Component $component)
    {
        if ($component->entry) {
            $component->fields->each(function ($field) use ($component) {
                $field->type()->setPrototypeAttribute('value', $component->entry->{$field->handle});
                $field->input()->load($component->entry->{$field->handle});
            });
        }
    }
}
