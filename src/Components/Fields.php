<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Fields extends Component
{
    public string $template = 'ui::components.fields';

    public array $fields = [];

    public function booted()
    {
        if ($this->stream) {
            foreach ($this->fields as &$field) {
                $field['stream'] = $this->stream;
            }
        }
    }
}
