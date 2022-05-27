<?php

namespace Streams\Ui\Components\Form;

use Streams\Ui\Support\Builder;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\FieldCollection;
use Streams\Core\Stream\Stream;
use Streams\Ui\Components\Table\Action\Action;
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
        // if ($component->stream) {
        //     $component->stream->fields->each(
        //         fn($field) => $component->fields->put($field->handle, $field)
        //     );
        // }

        $fields = $component->fields->all();

        foreach ($fields as &$field) {

            if (!array_key_exists('type', $field)) {
                $field['type'] = 'string';
            }

            if (!App::has('streams.core.field_type.' . $field['type'])) {
                throw new \Exception("Invalid field type [{$field['type']}] in stream [{$this->id}].");
            }

            $field = App::make('streams.core.field_type.' . $field['type'], [
                'attributes' => $field + ['stream' => $component->stream],
            ]);
        }

        $component->fields = new FieldCollection($fields);
    }

    public function makeActions(Component $component)
    {
        if ($component->actions()->collect()->isEmpty() && $component->stream->config('source')) {
            $component->actions = $component->actions()->collect()->add([
                'handle' => 'save',
                'handler' => Save::class
            ]);
        }

        if ($component->actions()->collect()->isEmpty() && !$component->stream->config('source')) {
            $component->actions = $component->actions()->collect()->add([
                'handle' => 'submit'
            ]);
        }

        $component->actions = $component->actions->map(function($action) {

            $action['form'] = $this;

            return new Action($action);
        })->keyBy('handle');
    }

    public function makeButtons(Component $component)
    {
        // if ($component->buttons()->collect()->isEmpty()) {
        //     $component->buttons = $component->buttons()->collect()->add([
        //         'handle' => 'cancel',
        //     ]);
        // }

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
