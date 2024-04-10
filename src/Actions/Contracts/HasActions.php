<?php

namespace Streams\Ui\Actions\Contracts;

use Streams\Ui\Actions\Action;

interface HasActions
{
    public function getActions(): array;
    public function getAction(string | array $name): ?Action;
}
