<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Collection;
use Streams\Ui\Support\Component;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Traits\HasAttributes;

class Table extends Component
{
    use HasStream;
    use HasAttributes;

    protected string $template = 'ui::components.table';

    public ?string $stream = null;

    protected array $columns = [];
    protected array $buttons = [];

    public function render()
    {
        return view($this->template);
    }

    public function getEntries(): Collection
    {
        return Streams::entries($this->stream)->get();
    }

    public function columns(array $columns): static
    {
        $this->columns = [
            ...$this->columns,
            ...$columns,
        ];

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function buttons(array $buttons): static
    {
        $this->buttons = [
            ...$this->buttons,
            ...$buttons,
        ];

        return $this;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }
}
