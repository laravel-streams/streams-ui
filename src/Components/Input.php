<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;

abstract class Input extends Component
{
    public ?string $placeholder = null;

    public function render(array $payload = [])
    {
        $payload['input'] = $payload;

        return parent::render($payload);
    }

    public function post()
    {
        return Request::file($this->alias) ?: $this->request($this->alias);
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes($attributes);
    }
}
