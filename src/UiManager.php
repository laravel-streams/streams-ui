<?php

namespace Streams\Ui;

use Illuminate\Support\Arr;
use Streams\Ui\Builders\Panels\Panel;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class UiManager
{
    use Macroable;
    use FiresCallbacks;

    protected array $panels = [];

    protected ?string $current = null;

    public function panel(Panel $panel): void
    {
        $this->panels[$panel->getId()] = $panel;

        $panel->register();

        if ($panel->isDefault()) {
            $this->setCurrentPanel($panel);
        }
    }

    public function getPanels(): array
    {
        return $this->panels;
    }

    public function getPanel(?string $id = null): Panel
    {
        return $this->panels[$id] ?? $this->getDefaultPanel();
    }

    public function getDefaultPanel(): Panel
    {
        return Arr::first(
            $this->panels,
            fn (Panel $panel): bool => $panel->isDefault(),
            fn () => throw new \Exception('No default panel defined.'),
        );
    }

    public function setCurrentPanel(Panel $panel): void
    {
        $this->current = $panel->getId();
    }

    public function currentPanel(): Panel
    {
        return $this->panels[$this->current];
    }
}
