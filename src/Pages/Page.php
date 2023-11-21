<?php

namespace Streams\Ui\Pages;

use Livewire\Component;
use Streams\Ui\Pages\Concerns;
use Streams\Ui\Support\Concerns\HasTitle;
use Streams\Ui\Support\Concerns\HasNavigation;

abstract class Page extends Component
{
    use HasTitle;
    use HasNavigation;

    use Concerns\HasRoutes;
    use Concerns\HasLayout;
    use Concerns\HasResource;

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
}
