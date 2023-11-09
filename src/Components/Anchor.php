<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Anchor extends Component
{
    use HasAttributes;

    public ?string $url = null;
    public ?string $text = null;

    protected string $template = 'ui::components.anchor';

    public function render()
    {
        return view($this->template);
    }
}
