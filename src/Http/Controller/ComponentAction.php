<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Routing\Controller;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Request;

class ComponentAction extends Controller
{
    public function __invoke($component, $action = null)
    {
        $component = UI::make($component, Request::input());

        if ($action) {
            $component->{$action}();
        }

        return $component->render();
    }
}
