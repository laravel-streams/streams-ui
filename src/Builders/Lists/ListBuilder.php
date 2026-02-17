<?php

namespace Streams\Ui\Builders\Lists;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ListBuilder extends ViewBuilder
{
    use Common\HasId;
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'list';

    protected string $view = 'ui::builders.list';

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
            'id' => $id ?: 'list-'.uniqid(),
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
}
