<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Builders;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Tables\Concerns\BelongsToTable;
use Streams\Ui\Builders\Inputs\Concerns\CanBeAutofocused;

class Filter extends ViewBuilder
{
    use BelongsToTable;

    use CanBeAutofocused;

    use Builders\Concerns\HasName;
    use Builders\Concerns\HasQuery;
    use Builders\Concerns\HasColumns;
    use Builders\Concerns\HasVisibility;
    use Builders\Concerns\CanBePersisted;
    use Builders\Concerns\CanSpanColumns;
    use Builders\Concerns\HasHtmlAttributes;

    use Builders\Containers\Concerns\HasContainers;

    protected string $view = 'ui::builders.filters.filter';

    protected string $viewIdentifier = 'filter';

    protected string $evaluationIdentifier = 'filter';

    protected string | \Closure | null $queryStringIdentifier = null;
    
    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(?string $name = null): static
    {
        $filter = static::class;

        $name ??= static::getDefaultName();

        if (blank($name)) {
            throw new \Exception("Filter [$filter] must have a name.");
        }

        $static = app($filter, ['name' => $name]);

        $static->configure();

        return $static;
    }

    public static function getDefaultName(): ?string
    {
        return null;
    }

    public function applySearch(Criteria $query, string $search): Criteria
    {
        if ($this->isHidden()) {
            return $query;
        }

        // if (!$this->hasQueryModificationCallback()) {
        //     return $query;
        // }

        $this->evaluate($this->query, [
            'query' => $query,
            'search' => $search,
        ]);

        return $query;
    }

    protected function resolveDefaultClosureDependency(string $name): array
    {
        return match ($name) {
            'livewire' => [$this->getLivewire()],
            'table' => [$this->getTable()],
            default => parent::resolveDefaultClosureDependency($name),
        };
    }
}
