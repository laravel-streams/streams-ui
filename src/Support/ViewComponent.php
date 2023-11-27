<?php

namespace Streams\Ui\Support;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\ComponentAttributeBag;

class ViewComponent extends Component implements Htmlable
{
    protected string $view;

    protected array $viewData = [];

    protected string $viewIdentifier;

    public function view(string | \Closure | null $view, array $data = []): static
    {
        if ($view === null) {
            return $this;
        }

        $this->view = $view;

        if ($data !== []) {
            $this->viewData($data);
        }

        return $this;
    }

    public function getView(): string
    {
        if (isset($this->view)) {
            return $this->evaluate($this->view);
        }

        throw new \Exception('Class [' . static::class . '] does not have a [protected string $view] property defined.');
    }

    public function viewData(array $data): static
    {
        $this->viewData = [
            ...$this->viewData,
            ...$data,
        ];

        return $this;
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

    public function toHtml(): string
    {
        return $this->render()->render();
    }

    public function render(): View
    {
        return view(
            $this->getView(),
            [
                'attributes' => new ComponentAttributeBag(),
                ...$this->extractPublicMethods(),
                ...(isset($this->viewIdentifier)
                    ? [$this->viewIdentifier => $this]
                    : []
                ),
                ...$this->viewData,
            ],
        );
    }

    protected string | \Closure | null $queryStringIdentifier = null;

    public function queryStringIdentifier(string | \Closure | null $identifier): static
    {
        $this->queryStringIdentifier = $identifier;

        return $this;
    }

    public function getQueryStringIdentifier(): ?string
    {
        return $this->evaluate($this->queryStringIdentifier);
    }
}
