<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Routing\Controller;
use Streams\Ui\Support\Facades\UI;

class ComponentResponse extends Controller
{
    public function __invoke($component, $entry = null)
    {
        $component = UI::make($component, array_filter([
            'entry' => $entry,
        ]));

        return $component->response();
    }
}
