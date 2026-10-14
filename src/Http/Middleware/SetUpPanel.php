<?php

namespace Streams\Ui\Http\Middleware;

use Illuminate\Http\Request;
use Streams\Ui\Support\Facades\UI;

class SetUpPanel
{
    public function handle(Request $request, \Closure $next, ?string $panel = null): mixed
    {
        UI::setCurrentPanel(UI::getPanel($panel));

        UI::bootCurrentPanel();

        return $next($request);
    }
}
