<?php

namespace Streams\Ui\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Builders\Concerns as Common;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class BasePage extends Component
{
    use FiresCallbacks;
    use HasMemory;
    
    use Concerns\HasLayout;
    use Concerns\HasResource;
    use Concerns\HasRoutes;

    // use Common\HasNavigation;
    // use Common\HasTitle;
    protected static ?string $title = null;

    public static function getTitle(): string
    {
        return static::$title ?? (string) str(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ')
            ->title();
    }

    // use Common\InteractsWithForms;

    use Common\EvaluatesClosures;
    use Common\HasDescription;

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
        $methods = $this->once(static::class.__FUNCTION__, function () {

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

        // $parameters['tenant'] ??= ($tenant ?? UI::getTenant());

        return route(static::getRouteName($panel), $parameters, $isAbsolute);
    }
}
