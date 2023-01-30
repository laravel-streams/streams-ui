<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;

class Field extends Component
{
    public string $template = 'ui::components.field';

    public string $name;

    public array $input = [
        'type' => 'input',
    ];

    public $label = null;

    public ?string $instructions = null;

    public bool $required = false;

    public function booted()
    {
        if (!$this->label && $this->label !== false) {
            $this->label = Str::title(Str::humanize($this->name));
        }

        $this->input['name'] = $this->name;
    }

    public function render(array $payload = [])
    {
        $payload['field'] = $this;

        return parent::render($payload);
    }
}
