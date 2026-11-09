<?php

namespace Streams\Ui\Builders\Concerns;

trait CanRefreshOn
{
    protected ?array $refreshOn = null;

    /**
     * Re-render when one of the events is broadcast on the channel.
     * Falls back to polling every $pollSeconds when window.Echo is absent.
     */
    public function refreshOn(
        string $channel,
        string|array $events,
        int $pollSeconds = 5,
        bool $private = false,
    ): static {
        $this->refreshOn = [
            'channel' => $channel,
            'events' => array_values((array) $events),
            'poll' => max(0, $pollSeconds) * 1000,
            'private' => $private,
        ];

        return $this;
    }

    public function getRefreshOn(): ?array
    {
        return $this->refreshOn;
    }

    public function getRefreshOnAttributes(): array
    {
        if ($this->refreshOn === null) {
            return [];
        }

        return [
            'data-refresh-on' => json_encode($this->refreshOn),
            'x-init' => "window.streamsRefreshOn && window.streamsRefreshOn.mount(\$el, typeof \$wire !== 'undefined' ? \$wire : null)",
        ];
    }
}
