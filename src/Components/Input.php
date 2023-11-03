<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Components\Traits\HasField;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Traits\HasAttributes;

abstract class Input extends Component
{
    use HasAttributes;
    use HasMemory;
    use HasStream;
    use HasField;

    public $id = null;

    protected $stream = null;
    protected $field = null;

    public $value = null;

    public ?string $name = null;

    public bool $readonly = false;
    public bool $disabled = false;
    public bool $required = false;

    public array $htmlAttributes = [];

    // public function post()
    // {
    //     if ($value = Request::post($this->name)) {
    //         return $value;
    //     }

    //     if ($file = Request::file($this->name)) {
    //         return $this->upload($file);
    //     }

    //     return null;
    // }
}
