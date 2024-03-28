<?php

namespace Streams\Ui\Http\Middleware;

use Illuminate\Http\Request;
use Streams\Ui\support\Facades\UI;

class SetUpPanel
{
    public function handle(Request $request, \Closure $next): mixed
    {
        UI::bootCurrentPanel();

        return $next($request);
    }
}
