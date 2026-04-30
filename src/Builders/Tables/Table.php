<?php

namespace Streams\Ui\Builders\Tables;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Support\Facades\Tables;
use Streams\Ui\Builders\Concerns as Common;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Streams\Ui\Builders\Tables\Columns\Column;
use Streams\Ui\Builders\Actions\Contracts\HasActions;

class Table extends ViewBuilder implements HasActions
{
    use Common\CanBeSorted;
    
    use Common\BelongsToLivewire;
    
    use Common\HasName;
    use Common\HasQuery;
    use Common\HasState;
    use Common\HasHeading;
    use Common\HasDescription;

    use Concerns\CanBePaginated;
    use Concerns\CanBeReordered;

    use Concerns\HasActions;
    use Concerns\HasColumns;
    use Concerns\HasFilters;
    use Concerns\HasViews;
    use Concerns\HasEntryUrl;
    use Concerns\HasEmptyState;
    use Concerns\HasBulkActions;
    use Concerns\HasEntryClasses;
    use Concerns\HasHeaderActions;

    protected string $view = 'ui::builders.table';

    protected string $viewIdentifier = 'table';

    protected string|\Closure|null $queryStringIdentifier = 'table';
    
    protected Collection|Paginator|null $entries = null;

    public function __construct($livewire, ?string $name = null)
    {
        $this->name($name ?? static::getDefaultName());
        
        $this->livewire($livewire);
    }

    public static function make($livewire, ?string $name = null): static
    {
        $instance = new static($livewire, $name);

        $instance->configure();

        Tables::register($instance->getName(), fn () => $instance);

        return $instance;
    }

    public static function for(Component $livewire, ?string $name = null): static
    {
        $resolvedName = $name ?? static::getDefaultName();

        $static = new static($livewire, $resolvedName);

        $static->livewire($livewire);
        $static->configure();

        return $static;
    }

    public static function register(Component $livewire, ?string $name = null): void
    {
        $resolvedName = $name ?? static::getDefaultName();

        Tables::register($resolvedName, fn () => static::for($livewire, $resolvedName));
    }

    public static function resolve(?string $name = null): ?static
    {
        $resolvedName = $name ?? static::getDefaultName();

        return Tables::resolve($resolvedName);
    }

    public function getEntries(): Collection|Paginator
    {
        if ($this->entries) {
            return $this->entries;
        }

        $query = $this->getFilteredSortedQuery();

        if (! $this->isPaginated()) {
            /** @var Collection $entries */
            $entries = $query->get();

            return $this->entries = $entries;
        }

        $this->entries = $this->paginate($query);

        $this->fire('entries_loaded', [
            'livewire' => $this->getLivewire(),
            'table' => $this,
        ]);

        return $this->entries;
    }

    public function flushEntries(): void
    {
        $this->entries = null;
    }

    public function setEntries(Collection|Paginator $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getFilteredSortedQuery(): Criteria|Builder
    {
        $query = $this->getFilteredQuery();
        $this->applySortingToQuery($query);

        return $query;
    }

    public function getFilteredQuery(): Criteria|Builder
    {
        return $this->filterQuery($this->getQuery());
    }

    public function filterQuery(Criteria|Builder $query): Criteria|Builder
    {
        $this->applyFiltersToQuery($query);
        $this->applySearchToQuery($query);

        return $query;
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

        if (! $column) {
            return null;
        }

        if (! $column->isSortable()) {
            return null;
        }

        return $column;
    }

    protected ?string $defaultSortColumn = null;

    protected string|\Closure|null $defaultSortDirection = null;

    protected ?\Closure $defaultSortQuery = null;

    public function defaultSort(
        string|\Closure|null $column,
        string|\Closure|null $direction = 'asc'
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

    protected static function getDefaultName(): string
    {
        $parts = explode('\\', static::class);

        return Str::kebab(end($parts));
    }

    protected function getDefaultStatePath(): string
    {
        return 'tables.'.$this->getName();
    }

    public function getState(string $key, mixed $default = null): mixed
    {
        return data_get($this->getLivewire(), $this->getStatePath().'.'.$key, $default);
    }

    public function setState(string $key, mixed $value): void
    {
        $livewire = $this->getLivewire();
        $path = $this->getStatePath().'.'.$key;
        data_set($livewire, $path, $value);
        $this->flushEntries();
    }

    public function getSearch(): ?string
    {
        $value = $this->getState('search');

        return filled($value) ? trim(strval($value)) : null;
    }

    public function getFiltersState(): array
    {
        return $this->getState('filters', []);
    }

    public function getFiltersStateValues(): array
    {
        $state = $this->getState('filters', []);

        $values = [];

        foreach ($state as $filter => $value) {
            $values[$filter] = $value['value'];
        }

        return array_filter($values);
    }

    public function getSortColumn(): ?string
    {
        return $this->getState('sort.column');
    }

    public function getSortDirection(): ?string
    {
        return $this->getState('sort.direction');
    }

    public function getSelectedEntryKeys(): array
    {
        return $this->getState('selected', []);
    }

    public function setSelectedEntryKeys(array $keys): void
    {
        $this->setState('selected', array_values(array_unique($keys)));
    }

    public function getRecordsPerPage(): int|string|null
    {
        $value = $this->getState('records_per_page', $this->getPerPage());

        return $value ?: $this->getPerPage();
    }

    public function applyFiltersToQuery(Criteria|Builder $query): Criteria|Builder
    {
        $data = $this->getFiltersState();

        foreach ($this->getFilters() as $filter) {
            if ($state = Arr::get($data, $filter->getName().'.value')) {
                $filter->apply($query, $this, $state);
            }
        }

        return $query;
    }

    public function applySearchToQuery(Criteria|Builder $query): Criteria|Builder
    {
        $search = $this->getSearch();

        if (blank($search)) {
            return $query;
        }

        foreach ($this->extractSearchWords($search) as $searchWord) {
            foreach ($this->getColumns() as $index => $column) {
                if (! $column->isSearchable()) {
                    continue;
                }

                $column->applySearch($query, $searchWord, $index === 0);
            }
        }

        return $query;
    }

    public function applySortingToQuery(Criteria|Builder $query): Criteria|Builder
    {
        $sortColumn = $this->getSortColumn();

        if (! $sortColumn) {
            return $this->applyDefaultSortingToQuery($query);
        }

        $column = $this->getSortableColumn($sortColumn);

        if (! $column) {
            return $this->applyDefaultSortingToQuery($query);
        }

        $sortDirection = $this->getSortDirection() === 'desc' ? 'desc' : 'asc';
        $column->applySort($query, $sortDirection);

        return $query;
    }

    public function applyDefaultSortingToQuery(Criteria|Builder $query): Criteria|Builder
    {
        $sortColumnName = $this->getDefaultSortColumn();
        $sortDirection = ($this->getDefaultSortDirection() ?? $this->getSortDirection()) === 'desc' ? 'desc' : 'asc';

        if ($sortColumnName) {
            return $query->orderBy($sortColumnName, $sortDirection);
        }

        if ($sortQueryUsing = $this->getDefaultSortQuery()) {
            app()->call($sortQueryUsing, [
                'direction' => $sortDirection,
                'query' => $query,
            ]);
        }

        return $query;
    }

    public function paginate(Criteria|Builder $query): Paginator
    {
        $perPage = $this->getRecordsPerPage();
        $pageName = $this->getTablePageName();
        $currentPage = $this->getLivewire()->paginators[$pageName] ?? 1;

        if ($query instanceof Criteria) {
            $records = $query->paginate([
                'per_page' => $perPage === 'all' ? $query->count() : $perPage,
                'page_name' => $pageName,
                'page' => $currentPage,
            ]);
        } else {
            $records = $query->paginate(
                $perPage === 'all' ? $query->count() : $perPage,
                ['*'],
                $pageName,
                $currentPage
            );
        }

        if ($records instanceof LengthAwarePaginator) {
            return $records->onEachSide(0);
        }

        return $records;
    }

    public function getTablePageName(): string
    {
        return $this->getLivewire()->getQueryStringPropertyName('page', $this->getName());
    }

    public function extractSearchWords(string $search): array
    {
        return array_filter(
            str_getcsv(preg_replace('/\s+/', ' ', $search), ' '),
            fn ($word): bool => filled($word),
        );
    }
}
