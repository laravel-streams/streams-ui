<?php

namespace Streams\Ui\Pages;

use Livewire\Component;
use Streams\Ui\Builders;
use Streams\Ui\Pages\Concerns;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Page extends Component
{
    use FiresCallbacks;
    
    use Concerns\HasRoutes;
    use Concerns\HasLayout;
    use Concerns\HasResource;

    use Builders\Concerns\HasTitle;
    use Builders\Concerns\HasNavigation;
    use Builders\Concerns\HasDescription;
    use Builders\Concerns\EvaluatesClosures;

    protected static string $view;

    protected static string $resource;

    public function render()
    {
        return view(static::$view, $this->getViewData())
            ->layout(static::$layout, [
                'livewire' => $this,
                ...$this->getLayoutData(),
            ]);
    }

    public static function getUrl(
        array $parameters = [],
        bool $isAbsolute = true,
        ?string $panel = null
        //?Model $tenant = null
    ): string {
        //$parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

        return route(static::getRouteName($panel), $parameters, $isAbsolute);
    }

    public function getHeaderActions(): array
    {
        return [];
    }
}
