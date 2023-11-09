<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Avatar extends Component
{
    use HasAttributes;

    public ?string $src = null;
    
    public array $query = [];

    public function render()
    {
        return view('ui::components.avatar');
    }

    public function src()
    {
        if (!$src = $this->src) { 
            return null;
        }

        if (filter_var($src, FILTER_VALIDATE_EMAIL)) {
            $src = 'https://gravatar.com/avatar/' . md5($src);
        }

        if ($this->query) {
            $src = $src . '?' . http_build_query($this->query);
        }

        return $src;
    }
}
