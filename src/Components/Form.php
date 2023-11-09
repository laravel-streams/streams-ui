<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Workflows\SaveForm;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Components\Workflows\FormBuilder;

class Form extends Component
{
    use HasStream;
    use HasAttributes;

    public string $template = 'ui::components.form';

    protected array $fields = [];
    protected array $buttons = [];

    public ?string $stream = null;

    public $entry = null;

    public function render()
    {
        return view($this->template);
    }

    public function buttons(array $buttons): static
    {
        $this->buttons = [
            ...$this->buttons,
            ...$buttons,
        ];

        return $this;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }
}
