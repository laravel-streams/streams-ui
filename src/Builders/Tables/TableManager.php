<?php

namespace Streams\Ui\Builders\Tables;

class TableManager
{
    protected array $tables = [];

    public function register(string $key, $table): void
    {
        $this->tables[$key] = $table;
    }

    public function resolve(string $key): ?Table
    {
        $table = $this->tables[$key] ?? null;

        if (is_callable($table) && ! ($table instanceof Table)) {
            $table = $table();

            if ($table instanceof Table) {
                $this->tables[$key] = $table;
            }
        }

        return $table instanceof Table ? $table : null;
    }

    public function all(): array
    {
        return $this->tables;
    }
}
