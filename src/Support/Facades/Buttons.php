<?php

namespace Streams\Ui\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Buttons extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Streams\Ui\Button\ButtonRegistry::class;
    }
}
