<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Support\Facades\UI;

class ComponentResponse extends Controller
{
    public function __invoke($component, $entry = null)
    {
        if (!UI::exists($component) && Str::is('*.*.*', $component)) {
            
            list($stream, $component, $handle) = explode('.', $component);

            return Streams::make($stream)->ui($component, $handle, [
                'stream' => Streams::make($stream),
                'entry' => Request::get('entry'),
                'handle' => $handle,
            ])->response();
        }

        $component = UI::make($component, array_filter([
            'entry' => $entry,
        ]));

        return $component->response();
    }
}
