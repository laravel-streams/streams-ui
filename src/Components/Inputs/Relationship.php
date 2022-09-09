<?php

namespace Streams\Ui\Components\Inputs;

use Illuminate\Support\Str;

use Streams\Ui\Components\Input;
use Streams\Core\Support\Facades\Streams;

class Relationship extends Input
{
    public string $template = 'ui::components.inputs.relationship';

    public function options()
    {
        $options = [];

        $stream = Streams::make($this->field->config['related']);

        $titleColumn = $stream->config('title_column', 'id');
        $keyName = $stream->config('key_name', 'id');

        $display = $this->config('display', '{' . ($titleColumn ?: $keyName) . '}');

        $entries = $stream->entries()->get();

        foreach ($entries as $entry) {
            $options[$entry->{$keyName}] = Str::parse($display, $entry->toArray());
        }

        return $options;
    }
}
