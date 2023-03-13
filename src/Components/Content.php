<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Content extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.content';

    public ?string $content = null;

    public array $attributes = [];
}
