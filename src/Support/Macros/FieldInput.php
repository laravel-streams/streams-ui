<?php

namespace Streams\Ui\Support\Macros;

use Livewire\Livewire;
use Livewire\Response;
use Illuminate\Support\Arr;

class FieldInput
{
    public function __invoke()
    {
        return function (array $attributes = []): Response {

            $attributes = Arr::add($attributes, 'field', $this);

            $attributes = array_merge($attributes, (array) $this->input);

            $attributes['stream'] = $this->stream->id;
            $attributes['field'] = $this->handle;

            if (!isset($attributes['type'])) {
                $attributes['type'] = 'text';
            }

            $type = Arr::pull($attributes, 'type');

            return Livewire::mount($type, $attributes);
        };
    }
}
