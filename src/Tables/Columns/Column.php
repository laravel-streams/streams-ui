<?php

namespace Streams\Ui\Tables\Columns;

use Streams\Ui\Traits as Support;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Tables\Columns\Concerns;

abstract class Column extends ViewBuilder
{
    use Support\HasIcon;
    use Support\HasName;
    use Support\HasState;
    use Support\HasColor;
    use Support\HasLabel;
    use Support\HasEntry;
    use Support\HasValue;
    use Support\HasTooltip;
    use Support\CanBeHidden;

    use Support\HasHtmlAttributes;

    use Concerns\HasTable;
    use Concerns\IsSortable;
    use Concerns\IsSearchable;
    use Concerns\InteractsWithQuery;

    protected string $viewIdentifier = 'column';

    public function __construct(string $name)
    {
        $this->name($name);

        $this->value(function ($entry) {

            $entry = $this->getEntryInstance();

            return $entry->{$this->getName()};
        });
    }

    static public function make($name): static
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
            //'stream' => [$this->getStream()],
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
