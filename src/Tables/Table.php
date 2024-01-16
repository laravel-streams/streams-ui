<?php

namespace Streams\Ui\Tables;

use Streams\Ui\Builders;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;

class Table extends Builders\ViewBuilder
{
    use Concerns\HasActions;
    use Concerns\HasColumns;
    use Concerns\HasFilters;
    use Concerns\HasBulkActions;
    use Concerns\HasHeaderActions;
    
    use Builders\Concerns\HasQuery;
    use Builders\Concerns\HasHeading;
    use Builders\Concerns\CanPaginate;
    use Builders\Concerns\HasDescription;
    
    use Builders\Concerns\BelongsToLivewire;

    protected string $view = 'ui::builders.table';

    protected string $viewIdentifier = 'table';
    
    protected string | \Closure | null $queryStringIdentifier = 'table';

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

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'table' => [$this],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
