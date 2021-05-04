<?php

namespace Streams\Ui\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasAttributes
{

    public function initializeAttributesAttribute(&$attributes)
    {
        /**
         * Make sure they exist.
         */
        $attributes['attributes'] = Arr::get($attributes, 'attributes', []);

        /**
         * Move the HREF if any to attributes.
         */
        if (isset($attributes['href'])) {
            Arr::set($attributes['attributes'], 'href', Arr::pull($attributes, 'href'));
        }

        /**
         * Move the URL if any to attributes.
         */
        if (isset($attributes['url'])) {
            Arr::set($attributes['attributes'], 'url', Arr::pull($attributes, 'url'));
        }

        /**
         * Move the target if any to attributes.
         */
        if (isset($attributes['target'])) {
            Arr::set($attributes['attributes'], 'target', Arr::pull($attributes, 'target'));
        }

        /**
         * Move all data-*|x-* keys to attributes.
         */
        foreach (array_keys($attributes) as $attribute) {
            if (Str::is(['data-*', 'x-*', '@*'], $attribute)) {
                Arr::set($attributes, 'attributes.' . $attribute, Arr::pull($attributes, $attribute));
            }
        }
    }

    public function setAttributesAttribute($attributes)
    {

        /**
         * Make sure the HREF is absolute.
         */
        if (
            isset($attributes['attributes']['href']) &&
            is_string($attributes['attributes']['href']) &&
            !Str::startsWith($attributes['attributes']['href'], ['http', '{', '//'])
        ) {
            $attributes['attributes']['href'] = url($attributes['attributes']['href']);
        }

        $this->setPrototypeAttributeValue('attributes', $attributes);
    }
}
