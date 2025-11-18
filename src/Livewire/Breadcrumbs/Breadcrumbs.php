<?php

namespace Streams\Ui\Livewire\Breadcrumbs;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Breadcrumbs extends ViewBuilder
{
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'breadcrumbs';

    protected string $view = 'ui::builders.breadcrumbs';

    protected array $items = [];

    final public function __construct(array $items = [])
    {
        if (filled($items)) {
            $this->items($items);
        }
    }

    public static function make(array $items = []): static
    {
        $instance = app(static::class, [
            'items' => $items,
        ]);

        $instance->configure();

        return $instance;
    }

    public function configure(): static
    {
        // Override in subclasses for custom configuration
        return $this;
    }

    public function items(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(string $title, ?string $href = null): static
    {
        $this->items[] = [
            'title' => $title,
            'href' => $href,
        ];

        return $this;
    }
}
