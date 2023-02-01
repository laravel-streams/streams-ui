<?php

namespace Streams\Ui\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;

class Input extends Component
{
    public string $template = 'ui::components.input';

    public string $name = 'input';

    public $value = null;

    public ?string $field = null;

    public bool $readonly = false;
    public bool $disabled = false;
    public bool $required = false;

    public function getRequestValue()
    {
        return Request::file($this->name) ?: Request::input($this->name);
    }

    public function field(): Field|null
    {
        if (!$this->field) {
            return null;
        }

        $key = __METHOD__ . '.' . $this->field;

        return $this->once($key, fn ()  => $this->stream()->fields->{$this->field});
    }
}
