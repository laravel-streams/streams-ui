<?php

namespace Streams\Ui\Actions;

use Streams\Ui\Actions\Action;

class ActionManager
{
    protected array $actions = [];

    protected static ?ActionManager $instance = null;

    public function register(string $key, $action): void
    {
        $this->actions[$key] = $action;
    }

    public function make(string $key): ?Action
    {
        $action = $this->actions[$key] ?? null;

        if (is_callable($action) && !($action instanceof Action)) {

            $action = $action();

            if ($action instanceof Action) {
                $this->actions[$key] = $action;
            }
        }

        return $action instanceof Action ? $action : null;
    }

    public function all(): array
    {
        return $this->actions;
    }
}
