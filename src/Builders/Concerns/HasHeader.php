<?php

namespace Streams\Ui\Builders\Tables\Concerns;

use Streams\Ui\Views\ViewComponent;

trait HasHeader
{
    protected string | array | \Closure | null $header = null;

    public function header(string | array | \Closure | null $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function getHeader(): ViewComponent | null
    {
        return $this->evaluate($this->header);
    }
}
