<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class TimeLine extends ViewBuilder
{
    use Common\HasHtmlAttributes;
    use Common\HasId;

    protected string $viewIdentifier = 'timeLine';

    protected string $view = 'ui::builders/time-line';

    protected array|\Closure $items = [];

    protected string|\Closure $mainTitle = '';

    public static function make(): static
    {
        return new static;
    }

    /**
     * Set the items for the timeline
     */
    public function items(array|\Closure $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function mainTitle(string|\Closure $title): static
    {
        $this->htmlAttributes(['data-main-title' => $this->evaluate($title)]);

        return $this;
    }

    /**
     * Get the items for the timeline
     */
    public function getItems(): array
    {
        return $this->evaluate($this->items);
    }
}
