<?php

namespace Streams\Ui\Builders\Tables\Columns;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Support;

abstract class Column extends ViewBuilder
{
    use Concerns\HasTable;
    use Concerns\InteractsWithQuery;
    use Concerns\IsSearchable;
    use Concerns\IsSortable;
    use Support\CanBeHidden;
    use Support\HasColor;
    use Support\HasEntry;
    use Support\HasHtmlAttributes;
    use Support\HasIcon;
    use Support\HasLabel;
    use Support\HasName;
    use Support\HasState;
    use Support\HasTooltip;
    use Support\HasValue;

    protected string $viewIdentifier = 'column';

    public function __construct(string $name)
    {
        $this->name($name);

        $this->value(function ($entry) {

            $entry = $this->getEntryInstance();

            return $entry->{$this->getName()};
        });
    }

    public static function make($name): static
    {
        $static = new static($name);

        return $static;
    }

    public function getLabel(): string
    {
        $label = $this->evaluate($this->label) ?? (string) str($this->getName())
            ->beforeLast('.')
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();

        return $label;
    }

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'table' => [$this->getTable()],
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
