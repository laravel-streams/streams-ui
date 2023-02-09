<?php

namespace Streams\Ui\Support\Macros;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Facades\UI;

class FieldInput
{
    public function __invoke()
    {
        return function (array $attributes = []): string {

            $attributes = Arr::add($attributes, 'field', $this);

            $attributes = array_merge($attributes, (array) $this->input);

            $attributes['stream'] = $this->stream->id;
            $attributes['field'] = $this->handle;

            if (!isset($attributes['type'])) {
                $attributes['type'] = 'text';
            }

            return $this->once(
                $this->stream->id . $this->handle . 'input',
                function () use ($attributes) {

                    $type = Arr::pull($attributes, 'type');

                    return UI::make($type, $attributes);
                }
            );
        };
    }
}
