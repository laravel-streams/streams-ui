<?php

namespace Streams\Ui\Builders\Headings;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Heading extends ViewBuilder
{
    use Common\HasActions;
    use Common\HasBadge;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasTitle;
    use Common\HasUrl;

    protected string $viewIdentifier = 'heading';

    protected string $view = 'ui::builders.heading';

    final public function __construct(string|\Closure|null $title = null)
    {
        if (filled($title)) {
            $this->title($title);
        }
    }

    public static function make(string|\Closure|null $title = null): static
    {
        $instance = app(static::class, [
            'title' => $title,
        ]);

        $instance->configure();

        return $instance;
    }

    protected string|\Closure|null $priority = 'h1';

    public function priority(string|\Closure|null $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->evaluate($this->priority);
    }
}
