<?php

namespace Streams\Ui\Resources\Concerns;

use Streams\Core\Stream\Stream;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Support\Facades\Streams;

trait HasStream
{
    protected static ?string $stream = null;
    
    public static function getStream(): string
    {
        return static::$stream ?? static::getSlug();
    }

    public static function makeStream(): Stream
    {
        return Streams::make(self::getStream());
    }

    public static function streamEntries(): Criteria
    {
        return Streams::make(self::getStream())->entries();
    }
}
