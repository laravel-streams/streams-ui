<?php

namespace Streams\Ui\Builders\Panels\Concerns;

trait HasRoutes
{
    protected string $path = '';

    protected array $domains = [];

    protected \Closure | null $routes = null;

    public function path(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function domain(?string $domain): static
    {
        $this->domains(filled($domain) ? [$domain] : []);

        return $this;
    }

    public function domains(array $domains): static
    {
        $this->domains = $domains;

        return $this;
    }

    public function routes(?\Closure $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    public function getRoutes(): ?\Closure
    {
        return $this->routes;
    }
}
