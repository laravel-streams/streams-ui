<?php

namespace Streams\Ui\Support\Concerns;

trait CanSpanColumns
{
    protected array $columnSpan = [
        'default' => 1,
        'sm' => null,
        'md' => null,
        'lg' => null,
        'xl' => null,
        '2xl' => null,
    ];

    protected array $columnStart = [
        'default' => null,
        'sm' => null,
        'md' => null,
        'lg' => null,
        'xl' => null,
        '2xl' => null,
    ];

    public function columnSpan(array | int | string | \Closure | null $span): static
    {
        if (!is_array($span)) {
            $span = [
                'default' => $span,
            ];
        }

        $this->columnSpan = [
            ...$this->columnSpan,
            ...$span,
        ];

        return $this;
    }

    public function fullWidth(): static
    {
        $this->columnSpan('full');

        return $this;
    }

    public function columnStart(
        array | int | string | \Closure | null $start
    ): static {

        if (!is_array($start)) {
            $start = [
                'default' => $start,
            ];
        }

        $this->columnStart = [
            ...$this->columnStart,
            ...$start,
        ];

        return $this;
    }

    public function getColumnSpan(
        int | string | null $breakpoint = null
    ): array | int | string | null {

        $span = $this->columnSpan;

        if ($breakpoint !== null) {
            return $this->evaluate($span[$breakpoint] ?? null);
        }

        return array_map(
            fn (array | int | string | \Closure | null $value): array | int | string | null => $this->evaluate($value),
            $span,
        );
    }

    public function getColumnStart(
        int | string | null $breakpoint = null
    ): array | int | string | null {
        
        $start = $this->columnStart;

        if ($breakpoint !== null) {
            return $this->evaluate($start[$breakpoint] ?? null);
        }

        return array_map(
            fn (array | int | string | \Closure | null $value): array | int | string | null => $this->evaluate($value),
            $start,
        );
    }
}
