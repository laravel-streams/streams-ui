<?php

namespace Streams\Ui\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Traits\HasAttributes;

class Input extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.input';

    public ?string $field = null;    
    
    public $value = null;
    
    public ?string $name = null;

    public bool $readonly = false;
    public bool $disabled = false;
    public bool $required = false;

    public array $attributes = [];

    public function field(): Field|null
    {
        $key = __METHOD__ . '.' . $this->field;

        return $this->field ? $this->once($key, fn ()  => $this->stream()->fields->{$this->field}) : null;
    }
}
