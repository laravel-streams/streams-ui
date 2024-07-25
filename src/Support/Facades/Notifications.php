<?php

namespace Streams\Ui\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Notifications extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'notifications';
    }
}
