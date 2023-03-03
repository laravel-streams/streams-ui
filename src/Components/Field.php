<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasField;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Components\Workflows\FieldBuilder;

class Field extends Component
{
    use HasField;
    use HasAttributes;

    public $workflow = FieldBuilder::class;

    public string $template = 'ui::components.field';

    // @todo Enum FT
    public string $width = 'full';
    
    public string|bool|null $label = null;
    public string|bool|null $instructions = null;
    public string|bool|null $description = null;

    public bool $required = false;

    public array $input = [];
    
    public array $attributes = [];
}
