<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait CanBeDateConstrained
{
    protected int | \Closure | null $maxDate = null;

    protected int | \Closure | null $minDate = null;

    public function maxDate(\DateTime | string | \Closure | null $date): static
    {
        $this->maxDate = $date;

        $this->rule(static function ($component) {
            return "before_or_equal:{$component->getMaxDate()}";
        }, static fn ($component): bool => (bool) $component->getMaxDate());

        return $this;
    }

    public function minDate(\DateTime | string | \Closure | null $date): static
    {
        $this->minDate = $date;

        $this->rule(static function ($component) {
            return "after_or_equal:{$component->getMinDate()}";
        }, static fn ($component): bool => (bool) $component->getMinDate());

        return $this;
    }

    public function getMaxDate(): ?int
    {
        return $this->evaluate($this->maxDate);
    }

    public function getMinDate(): ?int
    {
        return $this->evaluate($this->minDate);
    }
}
