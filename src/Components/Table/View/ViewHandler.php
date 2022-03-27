<?php

namespace Streams\Ui\Components\Table\View;

use Illuminate\Support\Facades\App;
use Streams\Ui\Components\Table\TableBuilder;
use Streams\Ui\Components\Table\View\View;

/**
 * Class ViewHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewHandler
{

    /**
     * Handle the view's table modification.
     *
     * @param TableBuilder  $builder
     * @param View $view
     */
    public function handle(TableBuilder $builder, View $view)
    {
        // @todo: What would they handle?
        //App::call($view->handler ?: [$view, 'apply'], compact('builder'), 'handle');
    }
}
