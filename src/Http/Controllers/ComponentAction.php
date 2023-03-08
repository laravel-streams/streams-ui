<?php

namespace Streams\Ui\Http\Controllers;

use Illuminate\Routing\Controller;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class ComponentAction extends Controller
{
    public function __invoke($component, $method = 'render')
    {
        $parameters = json_decode(Cache::get('ui::component.' . $component), true);

        if (!$parameters && UI::exists($component)) {
            $parameters = [
                'component' => $component,
            ];
        }

        if (!$parameters) {
            return abort(400, "Component [{$component}] not found.");
        }

        $component = UI::make($parameters['component'], array_merge($parameters['attributes'] ?? [], Request::query()));

        $response = $component->{$method}();

        if ($response instanceof Response) {
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
