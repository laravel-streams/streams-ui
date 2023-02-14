<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Str;
use Livewire\Livewire;
use Streams\Ui\Support\Component;
use Streams\Core\Field\Field as StreamsField;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Support\Facades\UI;

class Field extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.field';

    public ?string $field = null;

    public ?string $name = null;
    public ?string $description = null;

    public array $input = [];

    public $label = null;

    public ?string $instructions = null;

    public bool $required = false;

    public array $attributes = [];

    public function booted()
    {
        if ($this->stream && $this->field) {

            $field = $this->stream()->fields->{$this->field};

            $this->label = $field->name;
            $this->name = $field->handle;
            $this->description = $field->description;
            $this->instructions = $field->instructions;
            $this->required = $field->isRequired();

            //$this->input = array_merge($this->input, (array) $field->input);

            $this->input['stream'] = $this->stream;
            $this->input['field'] = $this->field;

            if (!isset($this->input['type'])) {
                // @todo map this
                $this->input['type'] = $field->type;
            }

            if ($this->input['type'] == 'datetime') {
                $this->input['type'] = 'datetime-input';
            }

            //$this->input['value'] = $field->default($field->config('default'));
        }

        if (!$this->label && $this->label !== false) {
            $this->label = Str::title(Str::humanize($this->name));
        }

        $this->input['name'] = $this->name;
        $this->input['required'] = $this->required;

        if (!isset($this->input['type'])) {
            $this->input['type'] = 'input';
        }
    }

    public function field(): StreamsField|null
    {
        return $this->once(__METHOD__ . '.' . $this->field, fn ()  => $this->stream()->fields->{$this->field});
    }
}
