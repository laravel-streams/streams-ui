<?php

namespace Streams\Ui\Lists;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\App;

class UiList extends ViewBuilder
{
    use Common\HasId;
    use Common\HasHtmlAttributes;

    protected string $view = 'ui::components.lists.list';
    
    protected array $items = [];

    final public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    public static function make(?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id ?: 'list-' . uniqid(),
        ]);

        $instance->configure();

        return $instance;
    }

    /**
     * Set the items for the list
     */
    public function items(array|\Closure $items): static
    {
        $this->items = $items;
        
        return $this;
    }

    /**
     * Get the items for the list
     */
    public function getItems(): array
    {
        if (is_callable($this->items)) {
            return call_user_func($this->items);
        }

        return $this->items;
    }

    /**
     * Get the view data
     */
    public function getViewData(): array
    {
        return array_merge([
            'id' => $this->getId(),
            'items' => $this->getItems(),
            'htmlAttributes' => $this->getHtmlAttributeBag(),
        ], $this->viewData);
    }
}
