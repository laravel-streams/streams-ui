<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Str;
use Streams\Ui\Components\Field;
use Streams\Core\Support\Workflow;

class FieldBuilder extends Workflow
{
    public array $steps = [
        'configure_field' => self::class . '@configureField',
        'configure_field_input' => self::class . '@configureFieldInput',
        'configure_defaults' => self::class . '@configureDefaults',
    ];

    public function configureField(Field $component): void
    {
        if (!$field = $component->field()) {
            return;
        }
        
        $attributes = [
            'description' => $field->description,
            'instructions' => $field->instructions,
            'label' => Str::title(Str::humanize($field->handle)),
        ];

        foreach ($attributes as $name => $value) {

            if ($component->{$name} === false) {
                continue;
            }

            $component->{$name} = $value;
        }

        $component->required = $field->isRequired();
    }

    public function configureFieldInput(Field $component)
    {
        if (!$field = $component->field()) {
            return;
        }

        $input = $component->input;
        
        // Pass through the stream and field.
        $input['stream'] = $component->stream;
        $input['field'] = $component->field;

        if (!array_key_exists('label', $input)) {
            $input['label'] = __($field->name());
        }

        if (!isset($input['type'])) {
            $input['type'] = $field->type;
        }

        if (!isset($input['name'])) {
            $input['name'] = $component->field;
        }

        $component->input = $input;
    }

    public function configureDefaults(Field $component)
    {
        $input = $component->input;

        $input['required'] = $component->required;

        if (!isset($input['type'])) {
            $input['type'] = 'input';
        }

        $component->input = $input;
    }
}
