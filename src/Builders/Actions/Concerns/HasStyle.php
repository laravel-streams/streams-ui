<?php

namespace Streams\Ui\Builders\Actions\Concerns;

use Streams\Ui\Builders\Concerns\HasStyle as HasStyleConcern;

trait HasStyle
{
    use HasStyleConcern;

    public function getStyle(): ?string
    {
        return $this->evaluate($this->style) ?? 'button';
    }
}
