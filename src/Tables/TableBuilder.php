<?php

namespace Streams\Ui\Tables;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Traits as Common;
use Streams\Ui\Components\Tables\TableComponent;
use Illuminate\Support\Facades\App;

class TableBuilder extends ViewBuilder
{
    use Common\HasId;
    use Common\HasHtmlAttributes;

    protected string $view = 'ui::components.tables.table-builder';
    
    protected \Closure $tableBuilder;
    protected ?TableComponent $component = null;

    final public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    public static function make(\Closure $tableBuilder, ?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id ?: 'table-' . uniqid(),
        ]);

        $instance->tableBuilder = $tableBuilder;
        $instance->configure();

        return $instance;
    }

    /**
     * Get the TableComponent instance
     */
    public function getComponent(): TableComponent
    {
        if (!$this->component) {
            $this->component = new TableComponent();
            $this->component->mount($this->tableBuilder);
        }

        return $this->component;
    }

    /**
     * Get the underlying Table instance
     */
    public function getTable(): Table
    {
        return $this->getComponent()->getTable();
    }

    /**
     * Get the view data
     */
    public function getViewData(): array
    {
        return array_merge([
            'id' => $this->getId(),
            'component' => $this->getComponent(),
            'htmlAttributes' => $this->getHtmlAttributeBag(),
        ], $this->viewData);
    }
}
