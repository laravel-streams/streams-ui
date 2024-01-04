<?php

namespace Streams\Ui\Pages\Traits;

trait HasResource
{
    protected static string $resource;

    public static function getResource(): string
    {
        return static::$resource;
    }
}
