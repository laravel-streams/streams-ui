<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class File extends Input
{
    public string $template = 'ui::input/file';
    public string $type = 'file';
    
    public array $accept = [
        // "image/png",
        // "image/jpeg"
    ];

    public function attributes(array $attributes = [])
    {
        $accept = $this->accept ?: Arr::get($this->field->config, 'accept', []);

        return parent::attributes(array_merge([
            'accept' => implode(', ', $accept),
        ], $attributes));
    }
}
