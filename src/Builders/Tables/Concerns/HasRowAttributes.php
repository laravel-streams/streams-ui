<?php

namespace Streams\Ui\Builders\Tables\Concerns;

use Illuminate\View\ComponentAttributeBag;
use Streams\Core\Entry\Contract\EntryInterface;

trait HasRowAttributes
{
    protected array $rowAttributes = [];

    public function rowAttributes(array|\Closure $attributes, bool $merge = false): static
    {
        if ($merge) {
            $this->rowAttributes[] = $attributes;
        } else {
            $this->rowAttributes = [$attributes];
        }

        return $this;
    }

    public function mergeRowAttributes(array|\Closure $attributes): static
    {
        return $this->rowAttributes($attributes, true);
    }

    public function getRowAttributes($entry): array
    {
        return $this->getRowAttributeBag($entry)->getAttributes();
    }

    public function getRowAttributeBag($entry): ComponentAttributeBag
    {
        $attributes = new ComponentAttributeBag;

        foreach ($this->rowAttributes as $rowAttributes) {
            $attributes = $attributes->merge(
                $this->evaluate(
                    $rowAttributes,
                    namedInjections: [
                        'entry' => $entry,
                    ],
                    typedInjections: [
                        EntryInterface::class => $entry,
                        $entry::class => $entry,
                    ],
                ) ?? [],
                escape: false,
            );
        }

        return $attributes;
    }
}
