<?php

namespace Streams\Ui\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

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
        if (Arr::get($action, 'ui.cp_enabled') == true) {
            View::share('cp', (new ControlPanelBuilder())->build());
        }

        //dd($action);

        return $next($request);
    }
}
