<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Traits\HasField;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Traits\HasAttributes;

abstract class Input extends Component
{
    use HasField;
    use HasStream;
    use HasAttributes;

    public ?string $stream = null;
    public ?string $field = null;

    public $value = null;

    public ?string $name = null;

    public bool $readonly = false;
    public bool $disabled = false;
    public bool $required = false;

    public array $attributes = [];

    public function post()
    {
        if ($value = Request::post($this->name)) {
            return $value;
        }

        if ($file = Request::file($this->name)) {
            return $this->upload($file);
        }

        return null;
    }
}
