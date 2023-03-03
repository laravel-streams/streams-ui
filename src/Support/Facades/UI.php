<?php

namespace Streams\Ui\Support\Facades;

use Illuminate\Support\Facades\Facade;

class UI extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Streams\Ui\UiManager::class;
    }
}
