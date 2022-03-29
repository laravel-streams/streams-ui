<?php

namespace Streams\Ui\Components\Form;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Value;
use Streams\Ui\Support\Builder;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Table\Row\Row;
use Streams\Ui\Components\Table\View\View;
use Streams\Ui\Components\Table\Action\Action;
use Streams\Ui\Components\Table\Column\Column;
use Streams\Ui\Components\Table\Filter\Filter;
use Streams\Ui\Components\Table\View\ViewHandler;
use Streams\Ui\Components\Form\Action\ActionCollection;
use Streams\Ui\Components\Form\Action\Handler\Save;

class FormBuilder extends Builder
{
    public function process(array $payload = []): void
    {
        $this->addStep('load_entry', self::class . '@loadEntry');

        $this->addStep('make_fields', self::class . '@makeFields');
        $this->addStep('load_fields', self::class . '@loadFields');

        $this->addStep('make_actions', self::class . '@makeActions');
        $this->addStep('make_buttons', self::class . '@makeButtons');

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

        if (is_object($component->entry)) {
            return;
        }

        $component->entry = $component->stream->repository()->find($component->entry);
    }

    public function makeFields(Component $component)
    {
        $component->fields = $component->actions()->collect()->filter(fn ($field) => $field->enabled !== false);

        $component->fields = $component->stream->fields;
    }

    public function makeActions(Component $component)
    {
        if ($component->actions()->collect()->isEmpty()) {
            $component->actions = $component->actions()->collect()->add([
                'handle' => 'save',
                'handler' => Save::class
            ]);
        }

        $component->actions = $component->actions->map(function($action) {

            $action['form'] = $this;

            return new Action($action);
        })->keyBy('handle');
    }

    public function makeButtons(Component $component)
    {
        if ($component->buttons()->collect()->isEmpty()) {
            $component->buttons = $component->buttons()->collect()->add([
                'handle' => 'cancel',
            ]);
        }

        $component->buttons = $component->buttons()->collect()->map(function($button) {

            $action['form'] = $this;

            return new Button($button);
        })->keyBy('handle');
    }

    public function loadFields(Component $component)
    {
        if ($component->entry) {
            $component->fields->each(function ($field) use ($component) {
                $field->input()->setPrototypeAttribute('value', $component->entry->{$field->handle});
            });
        }
    }
}
