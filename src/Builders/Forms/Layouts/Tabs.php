<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasLabel;
use Streams\Ui\Builders\Forms\Concerns\HasComponents;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;

class Tabs extends ViewComponent
{
    use HasId;
    use HasLabel;
    use HasComponents;
    use HasHtmlAttributes;

    protected string $view = 'ui::components.form.tabs';

    protected int | \Closure $activeTab = 1;

    // protected string | \Closure | null $tabQueryStringKey = null;

    final public function __construct(?string $label = null)
    {
        $this->label($label);
    }

    public static function make(?string $label = null): static
    {
        $static = app(static::class, ['label' => $label]);

        $static->configure();

        return $static;
    }

    public function tabs(array | \Closure $tabs): static
    {
        $this->components($tabs);

        return $this;
    }

    public function activeTab(int | \Closure $activeTab): static
    {
        $this->activeTab = $activeTab;

        return $this;
    }

    // public function persistTabInQueryString(string | \Closure | null $key = 'tab'): static
    // {
    //     $this->tabQueryStringKey = $key;

    //     return $this;
    // }

    public function getActiveTab(): int
    {
        // if ($this->isTabPersistedInQueryString()) {
        //     $queryStringTab = request()->query($this->getTabQueryStringKey());

        //     foreach ($this->getChildComponentContainer()->getComponents() as $index => $tab) {
        //         if ($tab->getId() !== $queryStringTab) {
        //             continue;
        //         }

        //         return $index + 1;
        //     }
        // }

        return $this->evaluate($this->activeTab);
    }

    // public function getTabQueryStringKey(): ?string
    // {
    //     return $this->evaluate($this->tabQueryStringKey);
    // }

    // public function isTabPersistedInQueryString(): bool
    // {
    //     return filled($this->getTabQueryStringKey());
    // }
}
