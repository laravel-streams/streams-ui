<?php

namespace Streams\Ui;

use Illuminate\Support\Facades\Config;
use Streams\Ui\Components\Panel;
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
        $this->panels[$panel->name] = $panel;

        if ($panel->isDefault()) {
            $this->setCurrentPanel($panel->name);
        }
    }

    public function getPanels(): array
    {
        return $this->panels;
    }

    public function setCurrentPanel(?string $panel): void
    {
        $this->current = $panel;

        $instance = $this->panels[$panel] ?? null;

        Config::set([
            'livewire.layout' => $instance->getLayout(),
        ]);
    }

    public function currentPanel(): Panel
    {
        return $this->panels[$this->current];
    }
}
