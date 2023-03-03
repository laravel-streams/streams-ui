<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Form;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Workflow;

class FormBuilder extends Workflow
{
    public array $steps = [
        'load_stream_config' => self::class . '@loadStreamConfig',
        'set_defaults' => self::class . '@setDefaults',
        'load_entry' => self::class . '@loadEntry',
    ];

    /**
     * Load the configuration from the stream.
     */
    public function loadStreamConfig(Form $component): void
    {
        if (!$stream = $component->stream()) {
            return;
        }

        $forms = new Collection(Arr::get($stream?->ui, 'components', []));

        $form = $forms
            ->where('component', 'form')
            ->where('handle', $component->handle)
            ->first();

        unset($form['component']);

        if ($form) {
            foreach ($form as $key => $value) {
                $component->{$key} = $value;
            }
        }

        if (!$component->fields) {
            $component->fields = $stream->fields->map(fn ($field) => [
                'field' => $field->handle,
            ])->all();
        }

        foreach ($component->fields as &$field) {
            $field['entry'] = $component->entry;
            $field['stream'] = $component->stream;
        }
    }

    public function setDefaults(Form $component): void
    {
        $component->buttons = $component->buttons ?: [
            [
                'type' => 'submit',
                'text' => 'Submit',
            ],
            [
                'tag' => 'a',
                'type' => null,
                'text' => 'Cancel',
                'url' => '/' . Request::segment(1) . '/' . Request::segment(2),
            ],
        ];
    }

    public function loadEntry(Form $component): void
    {
        if (!$component->entry) {
            return;
        }

        $entry = $component->stream()->repository()->find($component->entry);

        foreach ($component->fields as &$field) {
            $field['input']['value'] = $entry->{Arr::get($field, 'field')} ?? null;
        }
    }
}
