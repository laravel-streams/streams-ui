<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Traits;

class TimeInput extends Input
{
    use Concerns\HasStep;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.time';

    protected \DateTime | string | \Closure | null $maxTime = null;

    protected \DateTime | string | \Closure | null $minTime = null;

    public function maxTime(\DateTime | string | \Closure | null $date): static
    {
        $this->maxTime = $date;

        $this->rule(static function (TimeInput $component) {
            return "before_or_equal:{$component->getMaxTime()}";
        }, static fn (TimeInput $component): bool => (bool) $component->getMaxTime());

        return $this;
    }

    public function minTime(\DateTime | string | \Closure | null $date): static
    {
        $this->minTime = $date;

        $this->rule(static function (TimeInput $component) {
            return "after_or_equal:{$component->getMinTime()}";
        }, static fn (TimeInput $component): bool => (bool) $component->getMinTime());

        return $this;
    }

    public function getMaxTime(): ?string
    {
        return $this->evaluate($this->maxTime);
    }

    public function getMinTime(): ?string
    {
        return $this->evaluate($this->minTime);
    }
}
