<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;

class Modal extends Component
{
    public string $component = 'modal';
    
    public string $template  = 'ui::components.modal';

    public function title(): string|null
    {
        if ($this->title === false) {
            return null;
        }

        if ($this->title === null) {
            $this->title = Str::title(Str::humanize($this->handle));
        }

        return $this->title;
    }
}
