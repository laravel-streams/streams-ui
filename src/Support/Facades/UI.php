<?php

namespace Streams\Ui\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class UI
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @method static \Streams\Ui\Component\Component make($handle = null)
 * @method static string handle()
 * @method static \Streams\Ui\Component\ComponentManager switch($handle = null)
 */
class UI extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ui';
    }
}
