<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Concerns;

class DateInput extends Input
{
    use Concerns\HasStep;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.date';

    protected \DateTime | string | \Closure | null $maxDate = null;

    protected \DateTime | string | \Closure | null $minDate = null;

    public function maxDate(\DateTime | string | \Closure | null $date): static
    {
        $this->maxDate = $date;

        $this->rule(static function (DateInput $component) {
            return "before_or_equal:{$component->getMaxDate()}";
        }, static fn (DateInput $component): bool => (bool) $component->getMaxDate());

        return $this;
    }

    public function minDate(\DateTime | string | \Closure | null $date): static
    {
        $this->minDate = $date;

        $this->rule(static function (DateInput $component) {
            return "after_or_equal:{$component->getMinDate()}";
        }, static fn (DateInput $component): bool => (bool) $component->getMinDate());

        return $this;
    }

    public function getMaxDate(): ?string
    {
        return $this->evaluate($this->maxDate);
    }

    public function getMinDate(): ?string
    {
        return $this->evaluate($this->minDate);
    }
}
