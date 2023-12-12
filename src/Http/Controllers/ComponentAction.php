<?php

namespace Streams\Ui\Http\Controllers;

use Illuminate\Routing\Controller;
use Streams\Ui\support\Facades\UI;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseObject;

class ComponentAction extends Controller
{
    public function __invoke($component, $method = 'render')
    {
        $parameters = json_decode(Request::get('data'), true);

        if (!$parameters && UI::exists($component)) {
            $parameters = [
                'component' => $component,
            ];
        }

        $parameters = array_merge($parameters, Request::query());

        if (!$parameters) {
            return abort(400, "Component [{$component}] not found.");
        }

        $component = UI::make($parameters['component'], array_merge($parameters['attributes'] ?? [], Request::query()));

        $response = $component->{$method}();

        if ($response instanceof ResponseObject) {
            return $response;
        }

        //if (Request::expectsJson()) {
            return Response::json([
                'dom' => (string) $component->render(),
                'data' => $component->toArray(),
            ]);
        // } else {
        //     return $component->render();
        // }
    }
}
