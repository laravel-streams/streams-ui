<?php

namespace Streams\Ui\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ComponentAction extends Controller
{
    public function __invoke($component, $method = 'render')
    {
        if (!$parameters = json_decode(Cache::get('ui::component.' . $component), true)) {
            return Redirect::back(419);
        }
        
        $component = UI::make($parameters['component'], $parameters['attributes']);

        $response = $component->{$method}();

        if ($response instanceof \Illuminate\Http\Response) {
            return $response;
        }

        if (Request::expectsJson()) {
            return Response::json([
                'dom' => (string) $component->render(),
                'data' => $component->toArray(),
            ]);
        } else {
            return $component->render();
        }
    }
}
