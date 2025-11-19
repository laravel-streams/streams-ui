<?php

namespace Streams\Ui\Livewire\Widgets\Concerns;

trait CanPoll
{
    protected static ?string $pollingInterval = null;

    protected function getPollingInterval(): ?string
    {
        return static::$pollingInterval;
    }
}
