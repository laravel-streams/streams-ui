<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Facades\Streams;

class Builder extends Workflow
{
    public array $steps = [
        'cast_stream' => self::class . '@castStream',
        'parse_attributes' => self::class . '@parseAttributes',
        'load_attributes' => self::class . '@loadAttributes',
    ];

    public function castStream(Collection $attributes)
    {
        if (!$stream = $attributes->get('stream')) {
            return;
        }

        if ($stream instanceof Stream) {
            return;
        }

        if (is_string($stream)) {
            $attributes->put('stream', Streams::make($stream));
        }
    }

    public function parseAttributes(Collection $attributes)
    {
        $payload = [
            'stream' => $attributes->get('stream'),
        ];

        $attributes->map(function($attribute) use ($payload) {
            
            if (is_string($attribute)) {
                return Str::parse($attribute, $payload);
            }

            if (is_array($attribute)) {
                return Arr::parse($attribute, $payload);
            }

            return $attribute;
        });
    }

    public function loadAttributes(Component $component, Collection $attributes)
    {
        $component->loadPrototypeAttributes(
            Arr::parse($attributes->all(), $component->toArray())
        );
    }
}
