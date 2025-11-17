<?php

namespace Streams\Ui\Builders\Actions\Contracts;

use Streams\Ui\Builders\Actions\Action;

interface HasActions
{
    public function getActions(): array;
    public function getAction(string | array $name): ?Action;
}
