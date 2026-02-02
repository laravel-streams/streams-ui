<?php

namespace Streams\Ui\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Builders\Concerns as Common;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\Livewire\Actions\InteractsWithActions;

abstract class Page extends Component
{
    use Concerns\HasLayout;
    use Concerns\HasNavigation;
    use Concerns\HasNavigationGroups;
    use Concerns\HasResource;
    use Concerns\HasRoutes;
    use FiresCallbacks;
    use HasMemory;

    // use Common\HasTitle;
    protected static ?string $title = null;

    public static function getTitle(): string
    {
        return static::$title ?? (string) str(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ')
            ->title();
    }

    use Common\EvaluatesClosures;
    use Common\HasActions;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    use InteractsWithActions;

    public ?array $data = [];
    
    public ?array $notifications = [];

    protected static string $view;

    protected static string $resource;

    protected ?string $statePath = 'data';

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
    ): string {
        return route(static::getRouteName($panel), $parameters, $isAbsolute);
    }
}
