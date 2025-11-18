<?php

namespace Streams\Ui\Components;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Component extends ViewBuilder
{
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'component';

    protected string $view = 'ui::builders.component';

    protected string $livewireComponent;

    final public function __construct(string $livewireComponent)
    {
        $this->livewireComponent = $livewireComponent;
    }

    public static function make(string $livewireComponent): static
    {
        $instance = app(static::class, [
            'livewireComponent' => $livewireComponent,
        ]);

        $instance->configure();

        return $instance;
    }

    public function configure(): static
    {
        // Override in subclasses for custom configuration
        return $this;
    }

    public function getLivewireComponent(): string
    {
        return $this->livewireComponent;
    }

    public function livewireComponent(string $livewireComponent): static
    {
        $this->livewireComponent = $livewireComponent;

        return $this;
    }
}
