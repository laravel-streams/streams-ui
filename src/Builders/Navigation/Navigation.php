<?php

namespace Streams\Ui\Builders\Navigation;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Navigation extends ViewBuilder
{
    use Common\CanBeOutlined;
    use Common\HasActiveColor;
    use Common\HasBorderRadius;
    use Common\HasHtmlAttributes;
    use Common\HasId;
    use Common\HasStyle;

    protected string $viewIdentifier = 'navigation';

    protected string $view = 'ui::builders.navigation';

    protected array $items = [];

    final public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }

        $this->style('underline');
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
     *
     * @return array<int, NavigationItem>
     */
    public function getItems(): array
    {
        $items = is_callable($this->items)
            ? call_user_func($this->items)
            : $this->items;

        return array_values(array_filter(
            $items,
            fn ($item) => $item instanceof NavigationItem && ! $item->isHidden()
        ));
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

    /**
     * Resolve Tailwind classes for the active accent color.
     *
     * Full class strings are returned so Tailwind's content scanner can see them.
     *
     * @return array{text: string, textStrong: string, bg: string, border: string}
     */
    public function getActiveColorClasses(): array
    {
        return match ($this->getActiveColor()) {
            'danger', 'red' => [
                'text' => 'text-red-600',
                'textStrong' => 'text-red-700',
                'bg' => 'bg-red-600',
                'border' => 'border-red-500',
            ],
            'success', 'green' => [
                'text' => 'text-green-600',
                'textStrong' => 'text-green-700',
                'bg' => 'bg-green-600',
                'border' => 'border-green-500',
            ],
            'warning', 'amber' => [
                'text' => 'text-amber-600',
                'textStrong' => 'text-amber-700',
                'bg' => 'bg-amber-600',
                'border' => 'border-amber-500',
            ],
            'gray' => [
                'text' => 'text-gray-700',
                'textStrong' => 'text-gray-900',
                'bg' => 'bg-gray-700',
                'border' => 'border-gray-500',
            ],
            default => [
                'text' => 'text-primary-600',
                'textStrong' => 'text-primary-700',
                'bg' => 'bg-primary-600',
                'border' => 'border-primary-500',
            ],
        };
    }
}
