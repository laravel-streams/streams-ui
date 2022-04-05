<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Routing\Controller;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ComponentAction extends Controller
{
    public function __invoke($component, $action = null)
    {
        $component = UI::make($component, Request::input());

        if ($action) {
            $component->{$action}();
        }

        return Response::json([
            'dom' => (string) $component->render(),
        ]);
    }
}
