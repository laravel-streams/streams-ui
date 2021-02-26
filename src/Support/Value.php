<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Streams\Core\Entry\Contract\EntryInterface;

class Value
{

    /**
     * Make a value from the parameters and entry.
     *
     * @param $parameters
     * @param $payload
     * @param array $payload
     * @return mixed|string
     */
    public static function make($parameters, $entry, $term = 'entry', $payload = [])
    {

        /**
         * Load the termed entry.
         */
        $payload[$term] = $entry;

        /*
         * If a flat value was sent in
         * then convert it to an array.
         */
        if (!is_array($parameters)) {
            $parameters = [
                'value' => $parameters,
            ];
        }

        $value = Arr::get($parameters, 'value');

        // Return views.
        if ($view = Arr::get($parameters, 'view')) {
            return View::make($view, ['value' => $value, $term => $entry])->render();
        }

        /*
         * If the value uses a template then parse it.
         */
        if ($template = Arr::get($parameters, 'template')) {
            return View::parse($template, ['value' => $value, $term => $entry])->render();
        }

        /**
         * Check for basic entry attribute values.
         */
        if (is_object($entry) && method_exists($entry, 'getAttribute')) {
            $value = $entry->{$value};
        }

        /**
         * If the value is parsable
         * then try parsing it.
         */
        if (is_string($value) && Str::contains($value, ['{', '.'])) {

            $value = Str::parse($value, [
                'value' => $value,
                $term   => $entry,
            ]);

            $value = data_get([$term => $entry], $value, $value);
        }

        /*
         * If the value looks like a language
         * key then try translating it.
         */
        if (is_string($value) && Str::is('*.*.*::*', $value)) {
            $value = trans($value);
        }

        /*
         * Parse the wrapper with 
         * the value and the entry.
         */
        if ($wrapper = Arr::get($parameters, 'wrapper')) {
            $value = Str::parse($wrapper, [
                'value' => $value,
                $term => $entry
            ]);
        }

        /**
         * Escape if not safe.
         */
        if (is_string($value) && Arr::get($parameters, 'is_safe', true) === false) {
            $value = Str::purify($value);
        }

        /**
         * Ensure we have a string.
         */
        if (!is_string($value)) {
            $value = json_encode($value);
        }

        return $value;
    }
}
