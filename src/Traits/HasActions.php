<?php

namespace Streams\Ui\Traits;

use Illuminate\Support\Arr;
use Streams\Ui\Actions\Action;

trait HasActions
{
    protected array $actions = [];

    public function actions(array $actions): static
    {

        $this->actions = [
            ...$this->actions,
            ...$actions,
        ];

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function getAction(string | array | null $name = null): ?Action
    {
        $actions = $this->getActions();

        if ($name === null) {
            return Arr::first($this->actions);
        }

        if (is_string($name) && str($name)->contains('.')) {
            $name = explode('.', $name);
        }

        if (is_array($name)) {
            $firstName = array_shift($name);
            $modalActionNames = $name;

            $name = $firstName;
        }

        foreach ((array) $name as $search) {
            if ($action = Arr::first($actions, fn ($action) => $action->getName() === $search)) {
                return $action;
            }
        }

            if (
            (!str($name)->endsWith('Action')) &&
            method_exists($this, "{$name}Action")
        ) {
            return $this->{"{$name}Action"}();
        } elseif (method_exists($this, $name)) {
            return $this->{$name}();
        } else {
            return null;
        }

        return null;
    }
}
