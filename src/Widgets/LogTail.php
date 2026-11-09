<?php

namespace Streams\Ui\Widgets;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Support;

class LogTail extends ViewBuilder
{
    use Support\CanRefreshOn;
    use Support\HasHtmlAttributes;
    use Support\HasId;

    protected string $view = 'ui::widgets.log-tail';

    protected string $viewIdentifier = 'widget';

    protected \Closure|array|null $source = null;

    protected int $cap = 500;

    protected int $height = 320;

    public function __construct(string $id)
    {
        $this->id($id);
    }

    public static function make(?string $id = null): static
    {
        $static = new static($id ?: 'log-tail');

        $static->configure();

        return $static;
    }

    /** Closure (or array) returning the full list of lines, oldest first. */
    public function source(\Closure|array $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function cap(int $cap): static
    {
        $this->cap = max(1, $cap);

        return $this;
    }

    public function height(int $pixels): static
    {
        $this->height = $pixels;

        return $this;
    }

    public function getCap(): int
    {
        return $this->cap;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    /** @return array<int, string> */
    public function allLines(): array
    {
        $lines = $this->source instanceof \Closure ? ($this->source)() : ($this->source ?? []);

        return array_values(array_map('strval', (array) $lines));
    }

    /** The last `cap` lines. */
    public function getLines(): array
    {
        return array_slice($this->allLines(), -$this->cap);
    }

    /** Absolute index of the first line returned by getLines(). */
    public function getOffset(): int
    {
        return max(0, count($this->allLines()) - $this->cap);
    }
}
