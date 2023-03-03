<?php

namespace Streams\Ui\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasField;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Traits\HasAttributes;

class Input extends Component
{
    use HasField;
    use HasStream;
    use HasAttributes;

    public string $template = 'ui::components.input';

    public $value = null;
    
    public ?string $name = null;

    public bool $readonly = false;
    public bool $disabled = false;
    public bool $required = false;
}
