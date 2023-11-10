<?php

namespace Streams\Ui\Panels;

use Streams\Ui\Panels\Concerns;
use Streams\Ui\Support\Component;

class Panel extends Component
{
    use Concerns\HasId;
    use Concerns\HasPages;
    use Concerns\HasRoutes;
    use Concerns\HasMiddleware;
    use Concerns\HasNavigation;

    protected bool $default = false;

    protected string $layout = 'ui::layouts.app';

    static public function make(): static
    {
        $instance = new static;

        //$instance->configure();

        return $instance;
    }

    public function default(bool $condition = true): static
    {
        $this->default = $condition;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function layout(string $layout): static
    {
        $this->layout = $layout;

        return $this;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }
}
