<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;

abstract class Input extends Component
{
    public string $template = 'ui::components.input';

    public string $name;

    public $value = null;

    public bool $readonly = false;
    public bool $disabled = false;
    public bool $required = false;

    public function render(array $payload = [])
    {
        $payload['input'] = $this;

        return parent::render($payload);
    }

    public function post()
    {
        return Request::file($this->name) ?: $this->request($this->name);
    }
}
