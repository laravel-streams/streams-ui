<?php

namespace Streams\Ui\Support\Facades;

use Illuminate\Support\Facades\Facade;

class UI extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Streams\Ui\Support\UiManager::class;
    }
}
