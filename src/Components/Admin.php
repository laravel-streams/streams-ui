<?php

namespace Streams\Ui\Components;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Support\Facades\Breadcrumbs;

class Admin extends Component
{
    public ?string $layout = 'ui::layouts.admin';

    public function onBooted()
    {
        Breadcrumbs::put('admin', 'Admin');

        if ($stream = Request::segment(2)) {
            Breadcrumbs::put("admin/$stream", ucwords(Str::humanize($stream)));
        }

        if ($entry = Request::segment(3)) {
            Breadcrumbs::put("admin/$stream/$entry", ucwords(Str::humanize($entry)));
        }

        if ($action = Request::segment(4)) {
            Breadcrumbs::put("admin/$stream/$entry/$action", ucwords(Str::humanize($action)));
        }
    }
}
