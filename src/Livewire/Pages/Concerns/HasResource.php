<?php

namespace Streams\Ui\Livewire\Pages\Concerns;

trait HasResource
{
    protected static string $resource;

    public static function getResource(): string
    {
        return static::$resource;
    }
}
