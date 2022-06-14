<?php

namespace Streams\Ui\Components\Form;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Streams\Ui\Support\Builder;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Table\Action\Action;
use Streams\Ui\Components\Form\Action\Handler\Save;

class FormBuilder extends Builder
{
    public array $steps = [
        'cast_stream' => self::class . '@castStream',
        'load_attributes' => self::class . '@loadAttributes',

        'load_entry' => self::class . '@loadEntry',

        'make_fields' => self::class . '@makeFields',
        'load_fields' => self::class . '@loadFields',

        'make_actions' => self::class . '@makeActions',
        'make_buttons' => self::class . '@makeButtons',
    ];

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
        $configured = $component->fields;

        $component->fields = $component->stream->fields;

        // @todo Abstract this process in core
        foreach ($configured as $config) {

            $config['handle'] = Arr::get($config, 'handle');

            $rules = Arr::get($config, 'rules', []);

            if (Arr::pull($config, 'required') == true) {
                $rules[] = 'required';
            }

            if (Arr::pull($config, 'unique') == true) {
                $rules[] = 'unique';
            }

            $config['rules'] = $rules;

            if (!array_key_exists('type', $config)) {
                $config['type'] = 'string';
            }

            if (!App::has('streams.core.field_type.' . $config['type'])) {
                throw new \Exception("Invalid field type [{$config['type']}] in form [{__CLASS__}].");
            }

            $field = App::make('streams.core.field_type.' . $config['type'], [
                'attributes' => $config + ['stream' => $component->stream],
            ]);

            $component->fields->put($field->handle, $field);
        }

        $component->fields()->each(function ($field) use ($component) {
            $component->rules[$field->handle] = $field->rules();
        });
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

        $component->actions = $component->actions->map(function ($action) use ($component) {

            $action['form'] = $component;

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

        $component->buttons = $component->buttons()->collect()->map(function ($button) use ($component) {

            $button['form'] = $component;

            $button = Arr::parse($button, [
                'entry' => $component->entry,
            ]);

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
