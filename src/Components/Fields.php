<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;

class Fields extends Component
{
    public string $template = 'ui::components.fields';

    public array $fields = [];

    public function booted()
    {
        if (!$this->stream && $this->fields) {
            $this->stream = Arr::get($this->fields[0], 'stream');
        }

        if ($this->stream) {
            foreach ($this->fields as &$field) {
                $field['stream'] = $this->stream;
            }
        }
    }
}
