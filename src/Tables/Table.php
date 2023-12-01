<?php

namespace Streams\Ui\Tables;

use Streams\Ui\Tables\Concerns;
use Illuminate\Support\Collection;
use Streams\Ui\Views\ViewComponent;
use Streams\Ui\Support\Concerns\HasHeading;
use Streams\Ui\Support\Concerns\HasLivewire;
use Illuminate\Contracts\Pagination\Paginator;
use Streams\Ui\Support\Concerns\HasDescription;

class Table extends ViewComponent
{
    use HasLivewire;
    
    use HasHeading;
    use HasDescription;
    
    use Concerns\HasQuery;
    use Concerns\HasActions;
    use Concerns\HasColumns;
    use Concerns\HasEntries;
    use Concerns\CanPaginate;

    protected string $view = 'ui::components.table.index';

    protected string $viewIdentifier = 'table';

    public function __construct($livewire)
    {
        $this->livewire($livewire);
    }

    static public function make($livewire): static
    {
        $instance = new static($livewire);

        $instance->configure();

        return $instance;
    }

    public function getEntries(): Collection | Paginator
    {
        return $this->getTableEntries();
    }
}
