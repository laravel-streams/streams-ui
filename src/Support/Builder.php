<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Facades\Streams;

class Builder extends Workflow
{
    public array $steps = [
        'cast_stream' => self::class . '@castStream',
        'parse_attributes' => self::class . '@parseAttributes',
        'load_attributes' => self::class . '@loadAttributes',
    ];

    public function castStream(Component $component, Collection $attributes)
    {
        if (!$stream = $attributes->get('stream')) {

            $attributes = $attributes->put('stream', Streams::build([]));

            return;
        }

        if ($stream instanceof Stream) {
            return;
        }

        if (is_string($stream)) {
            $attributes = $attributes->put('stream', Streams::make($stream));
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
        if ($stream = $attributes->pull('stream')) {
            $component->stream = $stream;
        }

        $component->loadPrototypeAttributes(
            Arr::parse($attributes->all(), $component->toArray())
        );

        // Set the UI ID
        if (!isset($component->attributes['ui:id'])) {
            $component->attributes = array_merge($component->attributes, [
                'ui:id' => Str::random(20),
            ]);
        }
    }
}
