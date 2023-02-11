<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Anchor extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.anchor';

    public ?string $url = null;
    public ?string $text = null;

    public array $attributes = [];
}
