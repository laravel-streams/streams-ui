<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Avatar extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.avatar';

    public ?string $src = null;
    
    public array $query = [];

    public array $attributes = [];

    public function src(array $extra = [])
    {
        if (!$src = $this->src) { 
            return null;
        }

        if (filter_var($src, FILTER_VALIDATE_EMAIL)) {
            $src = 'https://gravatar.com/avatar/' . md5($src);
        }

        if ($extra) {
            $extra = array_replace_recursive($this->query, $extra);
        }

        if ($extra || $this->query) {
            $src = $src . '?' . http_build_query($extra ?: $this->query);
        }

        return $src;
    }
}
