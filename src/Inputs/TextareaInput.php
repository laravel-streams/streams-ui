<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Traits;

class TextareaInput extends Input
{
    use Concerns\HasPlaceholder;
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'ui::components.inputs.textarea';

    protected int | \Closure | null $columns = null;

    protected int | \Closure | null $rows = null;

    public function columns(int | \Closure | null $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function rows(int | \Closure | null $rows): static
    {
        $this->rows = $rows;

        return $this;
    }

    public function getColumns(): ?int
    {
        return $this->evaluate($this->columns);
    }

    public function getRows(): ?int
    {
        return $this->evaluate($this->rows);
    }
}
