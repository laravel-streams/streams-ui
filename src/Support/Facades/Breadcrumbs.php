<?php

namespace Streams\Ui\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Breadcrumbs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'breadcrumbs';
    }
}
