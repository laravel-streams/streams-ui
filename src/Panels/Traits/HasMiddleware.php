<?php

namespace Streams\Ui\Panels\Traits;

trait HasMiddleware
{
    protected array $middleware = [];

    public function middleware(array $middleware): static
    {
        $this->middleware = [
            ...$this->middleware,
            ...$middleware,
        ];

        return $this;
    }

    public function getMiddleware(): array
    {
        return [
            "panel:{$this->getId()}",
            ...$this->middleware,
        ];
    }
}
