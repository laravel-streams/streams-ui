<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Form extends Component
{
    public string $template = 'ui::components.form';

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
