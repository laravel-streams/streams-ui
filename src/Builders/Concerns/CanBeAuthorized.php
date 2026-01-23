<?php

namespace Streams\Ui\Builders\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Streams\Core\Entry\Contract\EntryInterface;

trait CanBeAuthorized
{
    protected mixed $authorization = null;

    public function authorize(
        mixed $abilities,
        EntryInterface|string|array|null $arguments = null
    ): static {

        if (is_string($abilities) || is_array($abilities)) {

            $this->authorization = [
                'type' => 'all',
                'abilities' => Arr::wrap($abilities),
                'arguments' => Arr::wrap($arguments),
            ];
        } else {
            $this->authorization = $abilities;
        }

        return $this;
    }

    public function authorizeAny(
        string|array $abilities,
        EntryInterface|array|null $arguments = null
    ): static {

        $this->authorization = [
            'type' => 'any',
            'abilities' => Arr::wrap($abilities),
            'arguments' => Arr::wrap($arguments),
        ];

        return $this;
    }

    public function isAuthorized(): bool
    {
        if ($this->authorization === null) {
            return true;
        }

        if (! is_array($this->authorization)) {
            return (bool) $this->evaluate($this->authorization);
        }

        $abilities = $this->authorization['abilities'] ?? [];
        $arguments = $this->authorization['arguments'] ?? [];

        $type = $this->authorization['type'] ?? null;

        return match ($type) {
            'all' => Gate::check($abilities, $arguments),
            'any' => Gate::any($abilities, $arguments),
            default => false,
        };
    }
}
