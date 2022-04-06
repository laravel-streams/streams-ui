<?php

namespace Streams\Ui\Components\Table\Action;

use Streams\Ui\Components\Button;
use Illuminate\Support\Facades\App;


class Action extends Button
{

    public string $tag = 'button';
    public string $name = 'action';

    public function handle(array $payload = [])
    {
        if (!$this->handler) {
            return;
        }

        App::call($this->handler, $payload);
    }
}
