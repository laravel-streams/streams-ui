<?php

namespace Streams\Ui\Pages;

use Livewire\Component;
use Streams\Ui\Builders;
use Streams\Ui\Pages\Concerns;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\Components\Forms\InteractsWithForms;

abstract class Page extends Component
{
    use HasMemory;
    use FiresCallbacks;

    use InteractsWithForms;
    
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
                ...$this->extractPublicMethods(),
            ]);
    }

    protected function extractPublicMethods(): array
    {
        $methods = $this->once(static::class . __FUNCTION__, function () {

            $reflection = new \ReflectionClass($this);

            return array_map(
                fn (\ReflectionMethod $method): string => $method->getName(),
                $reflection->getMethods(\ReflectionMethod::IS_PUBLIC),
            );
        });

        $values = [];

        foreach ($methods as $method) {
            $values[$method] = \Closure::fromCallable([$this, $method]);
        }

        return $values;
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
