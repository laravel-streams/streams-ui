<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Collapsable extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.collapsable';

    // @todo change to "toggle" component property
    public ?string $text = null;

    public array $content = [];

    public array $attributes = [];
}
