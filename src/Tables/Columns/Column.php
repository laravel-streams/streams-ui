<?php

namespace Streams\Ui\Tables\Columns;

use Streams\Ui\Support\Component;
use Streams\Ui\Tables\Columns\Concerns;
use Streams\Ui\Support\Concerns\HasIcon;
use Streams\Ui\Support\Concerns\HasName;
use Streams\Ui\Support\Concerns\HasLabel;
use Streams\Ui\Support\Concerns\HasEntry;

abstract class Column extends Component
{
    use HasIcon;
    use HasName;
    use HasLabel;
    use HasEntry;

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
        $entry = $this->getEntry();

        return $entry->{$this->getName()};
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
            'entry' => [$this->getEntry()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
