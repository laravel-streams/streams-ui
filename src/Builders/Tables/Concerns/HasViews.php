<?php

namespace Streams\Ui\Builders\Tables\Concerns;

use Streams\Ui\Builders\Tables\Views\ViewAction;

trait HasViews
{
    /** @var array<string, ViewAction> */
    protected array $views = [];

    protected ?string $defaultView = null;

    public function views(array $views): static
    {
        $this->views = [];

        return $this->pushViews($views);
    }

    public function pushViews(array $views): static
    {
        foreach ($views as $view) {
            $view->livewire($this->getLivewire());
            $this->views[$view->getName()] = $view;
        }

        return $this;
    }

    public function defaultView(?string $name): static
    {
        $this->defaultView = $name;

        return $this;
    }

    /**
     * @return array<string, ViewAction>
     */
    public function getTableViews(): array
    {
        return array_filter(
            $this->views,
            fn (ViewAction $view): bool => $view->isVisible(),
        );
    }

    public function getTableView(?string $name): ?ViewAction
    {
        if (! filled($name)) {
            return null;
        }

        return $this->getTableViews()[$name] ?? null;
    }

    public function getDefaultView(): ?string
    {
        return $this->defaultView;
    }

    public function isViewable(): bool
    {
        return (bool) count($this->getTableViews());
    }
}
