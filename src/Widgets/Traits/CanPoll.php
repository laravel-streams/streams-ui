<?php

namespace Streams\Ui\Widgets\Traits;

trait CanPoll
{
    protected static ?string $pollingInterval = null;

    protected function getPollingInterval(): ?string
    {
        return static::$pollingInterval;
    }
}
