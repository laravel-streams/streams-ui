<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Facades\Streams;

class Builder extends Workflow
{
    public array $steps = [
        'normalize_stream' => self::class . '@normalizeStream',
        'normalize_html_attributes' => self::class . '@normalizeHtmlAttributes',
        'load_attributes' => self::class . '@loadAttributes',
        'set_stream' => self::class . '@setStream'
    ];

    public function normalizeStream(Collection $attributes)
    {
        if (isset($attributes['stream']) && is_string($attributes['stream'])) {
            $attributes['stream'] = Streams::make($attributes['stream']);
        }
    }
    
    public function normalizeHtmlAttributes(Collection $attributes)
    {
        /**
         * Make sure they exist.
         */
        $html = Arr::get($attributes, 'attributes', []);

        /**
         * Move the HREF if any to attributes.
         */
        if (isset($attributes['href'])) {
            Arr::set($html, 'href', Arr::pull($attributes, 'href'));
        }

        /**
         * Move the URL if any to attributes.
         */
        if (isset($attributes['url'])) {
            Arr::set($html, 'url', Arr::pull($attributes, 'url'));
        }

        /**
         * Move the target if any to attributes.
         */
        if (isset($attributes['target'])) {
            Arr::set($html, 'target', Arr::pull($attributes, 'target'));
        }

        /**
         * Move all data-*|x-* keys to attributes.
         */
        foreach ($attributes->keys() as $attribute) {
            if (Str::is(['data-*', 'x-*', '@*'], $attribute)) {
                Arr::set($html, $attribute, Arr::pull($attributes, $attribute));
            }
        }

        /**
         * Make sure the HREF is absolute.
         */
        if (
            isset($html['href']) &&
            is_string($html['href']) &&
            !Str::startsWith($html['href'], ['http', '{', '//'])
        ) {
            $html['href'] = url($html['href']);
        }

        $attributes->put('attributes', $html);
    }

    public function loadAttributes(Component $component, Collection $attributes)
    {
        $component->syncOriginalPrototypeAttributes($attributes->all());
        $component->initializeComponentPrototype($attributes->all());
    }

    public function setStream(Component $component, Collection $attributes)
    {
        if (isset($attributes['stream'])) {
            $component->stream = $attributes['stream'];
        }
    }
}
