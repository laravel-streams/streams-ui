<?php

namespace Streams\Ui\Support;

use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Facades\Streams;

class Builder extends Workflow
{
    public array $steps = [
        'cast_stream' => self::class . '@castStream',
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

    public function loadAttributes(Component $component, Collection $attributes)
    {
        $component->loadPrototypeAttributes($attributes->all());
    }
}
