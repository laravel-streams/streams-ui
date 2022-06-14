<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Streams\Core\Support\Facades\Streams;

class Relationship extends Input
{
    public string $template = 'ui::components.inputs.relationship';

    public function options()
    {
        $options = [];

        $stream = Streams::make($this->field->config['related']);

        $keyName = $stream->config('key_name', 'id');

        $entries = $stream->entries()->get();

        foreach ($entries as $entry) {
            $options[$entry->{$keyName}] = $entry->title ?: ($entry->name ?: $entry->{$keyName});
        }

        return $options;
    }
}
