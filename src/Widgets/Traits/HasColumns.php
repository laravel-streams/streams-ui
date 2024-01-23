<?php

namespace Streams\Ui\Containers\Traits;

trait HasColumns
{
    protected ?array $columns = null;

    public function columns(array | int | string | null $columns = 2): static
    {
        if (!is_array($columns)) {
            $columns = [
                'default' => $columns,
            ];
        }

        $this->columns = [
            ...($this->columns ?? []),
            ...$columns,
        ];

        return $this;
    }

    public function getColumns(
        ?string $breakpoint = null
    ): array | int | string | null {
        
        $columns = $this->getColumnsConfig();

        if ($breakpoint !== null) {
            return $columns[$breakpoint] ?? null;
        }

        return $columns;
    }

    public function getColumnsConfig(): array
    {
        // @todo: This is a hack to get the parent component's columns config.
        // if ($this instanceof ComponentContainer && $this->getParentComponent()) {
        //     return $this->getParentComponent()->getColumnsConfig();
        // }

        return $this->columns ?? [
            'default' => null,
            'sm' => 1,
            'md' => null,
            'lg' => null,
            'xl' => null,
            '2xl' => null,
        ];
    }
}
