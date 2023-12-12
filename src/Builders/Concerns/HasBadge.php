<?php

namespace Streams\Ui\Builders\Concerns;

trait HasBadge
{
    protected string | \Closure | null $badge = null;

    protected string | array | \Closure | null $badgeColor = null;

    public function badge(
        string | \Closure | null $badge,
        string | array | \Closure | null $color = null
    ): static {

        $this->badge = $badge;
        $this->badgeColor = $color;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->evaluate($this->badge);
    }

    public function getBadgeColor(): string | array | null
    {
        return $this->evaluate($this->badgeColor);
    }
}
