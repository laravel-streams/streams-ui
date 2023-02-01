<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Str;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;

class ComponentResponse extends Controller
{
    public function __invoke($component, $entry = null)
    {
        if (!UI::exists($component) && Str::is('*.*.*', $component)) {

            list($stream, $component, $handle) = explode('.', $component);

            return Streams::make($stream)->ui($component, $handle, array_merge(
                Request::query(),
                [
                    'stream' => Streams::make($stream),
                    'entry' => Request::get('entry'),
                    'handle' => $handle,
                ]
            ))->response();
        }

        $component = UI::make($component, array_filter(array_merge(
            Request::query(),
            [
                'entry' => $entry,
            ]
        )));

        return $component->render();
    }
}
