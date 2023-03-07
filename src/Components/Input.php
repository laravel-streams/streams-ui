<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
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

    protected $dates = [
        'date' => 'Y-m-d',
        'time' => 'H:i:s',
        'datetime-local' => 'Y-m-d\TH:i:s',
    ];

    public function value()
    {
        if (!$this->value) {
            return $this->value;
        }

        if (in_array($this->type, array_keys($this->dates))) {
            return $this->value->format($this->dates[$this->type]);
        }

        return $this->value;
    }
}
