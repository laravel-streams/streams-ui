<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Support\Facades\UI;

class RenderComponent extends Controller
{
    public function __invoke($component)
    {
        $component = UI::make($component, Request::input());

        return $component->response();
    }
}
