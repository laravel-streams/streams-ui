<?php

namespace Streams\Ui\Pages;

use Livewire\Component;
use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Page extends Component
{
    use HasMemory;
    use FiresCallbacks;

    use Traits\HasRoutes;
    use Traits\HasLayout;
    use Traits\HasResource;
    use Traits\HasNavigation;

    use Common\HasTitle;
    use Common\HasDescription;
    use Common\InteractsWithForms;

    use Common\EvaluatesClosures;

    public ?array $data = [];
    
    protected static string $view;

    protected static string $resource;

    public function render()
    {
        return View::make(static::$view, $this->getViewData())
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
        // ?Entry $tenant = null
    ): string {
        
        //$parameters['tenant'] ??= ($tenant ?? UI::getTenant());

        return route(static::getRouteName($panel), $parameters, $isAbsolute);
    }
}
