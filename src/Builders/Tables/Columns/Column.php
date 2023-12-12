<?php

namespace Streams\Ui\Builders\Tables\Columns;

use Streams\Ui\Builders;
use Streams\Ui\Builders\Tables\Columns\Concerns;

abstract class Column extends Builders\Builder
{
    use Builders\Concerns\HasIcon;
    use Builders\Concerns\HasName;
    use Builders\Concerns\HasLabel;
    use Builders\Concerns\HasEntry;
    
    use Builders\Concerns\HasHtmlAttributes;

    use Concerns\HasTable;
    use Concerns\IsSortable;
    use Concerns\IsSearchable;

    public function __construct(string $name)
    {
        $this->name($name);
    }

    static public function make($name): static
    {
        $static = new static($name);

        return $static;
    }

    public function value(): string
    {
        $entry = $this->getEntryInstance();

        return $entry->{$this->getName()} ?: '';
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
