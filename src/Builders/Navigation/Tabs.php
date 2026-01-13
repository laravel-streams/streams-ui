<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Tabs extends ViewBuilder
{
    use Common\HasComponents;
    use Common\HasHtmlAttributes;
    use Common\HasId;
    use Common\HasLabel;

    protected string $view = 'ui::builders.navigation.tabs';

    protected int|\Closure $activeTab = 1;

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

    public function tabs(array|\Closure $tabs): static
    {
        $this->components($tabs);

        return $this;
    }

    public function activeTab(int|\Closure $activeTab): static
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
