<?php

namespace Streams\Ui\Components\Tables;

use Livewire\Component;
use Streams\Ui\Tables\Table;
use Streams\Ui\Components\Tables\InteractsWithTable;

class TableComponent extends Component
{
    use InteractsWithTable;

    protected static string $view = 'livewire.app.container';

    public array $notifications = [];

    protected Table $table;

    protected \Closure $tableBuilder;

    public function __construct()
    {
        // Initialize table to avoid issues
        $this->table = Table::make($this);
    }

    public function mount(\Closure $tableBuilder = null): void
    {
        if ($tableBuilder) {
            $this->tableBuilder = $tableBuilder;
            $this->table = call_user_func($tableBuilder, Table::make($this));
        }
    }

    public function getComponents(): array
    {
        return [
            $this->table
        ];
    }

    public function getTable(): Table
    {
        return $this->table;
    }

    public function render()
    {
        return view(static::$view, []);
    }
}
