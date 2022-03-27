<?php

namespace Streams\Ui\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Streams\Ui\Components\ControlPanel;

class LoadUi
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $action = $request->route()->getAction();

        /**
         * Enable the CP or not.
         */
        if (Arr::get($action, 'ui.cp_enabled') == true && !View::shared('cp')) {
            View::share('cp', new ControlPanel());
        }

        return $next($request);
    }
}
