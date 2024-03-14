<?php

namespace Streams\Ui\Tables\Columns;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Support;
use Streams\Ui\Tables\Columns\Concerns;

abstract class Column extends Builder
{
    use Support\HasIcon;
    use Support\HasName;
    use Support\HasColor;
    use Support\HasLabel;
    use Support\HasEntry;
    use Support\HasValue;

    use Support\HasHtmlAttributes;

    use Concerns\HasTable;
    use Concerns\IsSortable;
    use Concerns\IsSearchable;
    use Concerns\InteractsWithQuery;

    public function __construct(string $name)
    {
        $this->name($name);

        $this->value(function ($entry) {

            $entry = $this->getEntryInstance();
            
            return $entry->{$this->getName()} ?: '';
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
