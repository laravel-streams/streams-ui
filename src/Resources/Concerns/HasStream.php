<?php

namespace Streams\Ui\Resources\Concerns;

trait HasStream
{
    protected static ?string $stream = null;
    
    public static function getStream(): string
    {
        return static::$stream ?? static::getSlug();
    }
}
