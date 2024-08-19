<?php

namespace Streams\Ui\Tables\Concerns;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Contract\EntryInterface;

trait HasEntryClasses
{
    protected array | string | \Closure | null $rowClasses = null;

    public function rowClasses(array | string | \Closure | null $classes): static
    {
        $this->rowClasses = $classes;

        return $this;
    }

    public function getRowClasses(EntryInterface $entry): array
    {
        return Arr::wrap($this->evaluate(
            $this->rowClasses,
            namedInjections: [
                'entry' => $entry,
            ],
            typedInjections: [
                EntryInterface::class => $entry,
                $entry::class => $entry,
            ],
        ) ?? []);
    }
}
