<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class Value
{
    public static function make(
        string|array $parameters,
        mixed $entry = null,
        string $term = 'entry'
    ): string|null {

        /**
         * If the parameters are not an array
         * then we will assume it is the value.
         */
        if (!is_array($parameters)) {
            $parameters = [
                'value' => $parameters,
            ];
        }
        
        $value = $original = Arr::get($parameters, 'value');

        /**
         * First, simply parse the value
         * and include the entry data.
         */
        if (is_string($value)) {
            $value = Str::parse($value, [
                $term => $entry,
            ]);
        }

        if (is_array($value)) {
            $value = Arr::parse($value, [
                $term => $entry,
            ]);
        }

        /**
         * Check if the value is a
         * property of the entry object.
         */
        if (
            is_string($value)
            && is_object($entry)
            && property_exists($entry, $value)
        ) {
            $value = $entry->{$value};
        }

        /**
         * Check if the value is a
         * key of the entry data.
         */
        if (
            is_string($value)
            && is_array($entry)
            && array_key_exists($value, $entry)
        ) {
            $value = $entry[$value];
        }

        /**
         * Lastly, if the parameters include
         * the view option then render it.
         */
        if ($view = Arr::pull($parameters, 'view')) {
            return View::make($view, [
                'value' => $value,
                $term => $entry
            ])->render();
        }

        // Likewise, render templates.
        if ($template = Arr::get($parameters, 'template')) {
            return View::parse($template, [
                'value' => $value,
                $term => $entry
            ])->render();
        }

        // Escape by default.
        if (is_string($value) && Arr::get($parameters, 'is_safe', false) === false) {
            $value = Str::purify($value);
        }

        if ($value === $original) {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
