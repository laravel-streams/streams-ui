<?php

namespace Streams\Ui\Tables\Filters;

use Streams\Ui\Tables\Table;
use Streams\Ui\Traits as Support;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Inputs\Traits\CanBeAutofocused;
use Streams\Ui\Tables\Concerns\BelongsToTable;

class Filter extends ViewBuilder
{
    use BelongsToTable;

    use CanBeAutofocused;

    use Support\HasName;
    use Support\HasQuery;
    // use Support\HasColumns;
    use Support\CanBeHidden;
    use Support\HasComponents;
    use Support\CanPersistData;
    use Support\CanSpanColumns;
    use Support\HasHtmlAttributes;

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

    public function apply(Criteria $query, Table $table, $state): Criteria
    {
        // if ($this->isHidden()) {
        //     return $query;
        // }

        // if (!$this->hasQueryModificationCallback()) {
        //     return $query;
        // }

        // if (!($data['isActive'] ?? true)) {
        //     return $query;
        // }

        // $this->evaluate($this->modifyQueryUsing, [
        $this->evaluate($this->query, [
            'query' => $query,
            'table' => $table,
            // 'data' => $data,
            'state' => $state,
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
