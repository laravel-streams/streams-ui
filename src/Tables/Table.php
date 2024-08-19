<?php

namespace Streams\Ui\Tables;

use Illuminate\Support\Str;
use Streams\Ui\Traits as Support;
use Illuminate\Support\Collection;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Tables\Columns\Column;
use Streams\Ui\Actions\Contracts\HasActions;
use Illuminate\Contracts\Pagination\Paginator;

class Table extends ViewBuilder implements HasActions
{
    use Concerns\HasActions;
    use Concerns\HasColumns;
    use Concerns\HasFilters;
    use Concerns\HasBulkActions;
    use Concerns\HasEntryClasses;
    use Concerns\HasHeaderActions;

    use Concerns\HasEntryUrl;

    use Concerns\CanBeReordered;

    use Support\HasQuery;
    use Support\HasHeading;
    use Support\CanBePaginated;
    use Support\HasDescription;

    use Support\BelongsToLivewire;

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
        return $this->getLivewire()->getTableEntries();
    }

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'table' => [$this],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }

    public function getSortableColumn(string $name): ?Column
    {
        $column = $this->getColumn($name);

        if (!$column) {
            return null;
        }

        if (!$column->isSortable()) {
            return null;
        }

        return $column;
    }

    protected ?string $defaultSortColumn = null;

    protected string | \Closure | null $defaultSortDirection = null;

    protected ?\Closure $defaultSortQuery = null;

    public function defaultSort(
        string | \Closure | null $column,
        string | \Closure | null $direction = 'asc'
    ): static {

        if ($column instanceof \Closure) {
            $this->defaultSortQuery = $column;
        } else {
            $this->defaultSortColumn = $column;
        }

        $this->defaultSortDirection = $direction;

        return $this;
    }

    public function getDefaultSortColumn(): ?string
    {
        return $this->defaultSortColumn;
    }

    public function getDefaultSortDirection(): ?string
    {
        $direction = $this->evaluate($this->defaultSortDirection);

        if ($direction !== null) {
            $direction = Str::lower($direction);
        }

        return $direction;
    }

    public function getDefaultSortQuery(): ?\Closure
    {
        return $this->defaultSortQuery;
    }
}
