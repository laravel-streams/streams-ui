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

        $entries = Streams::entries($this->field->config['related'])->get();

        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->title ?: ($entry->name ?: $entry->id);
        }

        return $options;
    }
}
