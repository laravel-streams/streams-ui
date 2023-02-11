<?php

namespace Streams\Ui\Components\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Components\Navigation;
use Streams\Core\Support\Facades\Streams;

class AdminMenu extends Navigation
{
    public function booted()
    {
        // $streams = Streams::collection()->where('ui.cp.section', '!=', null);

        // foreach ($streams as $stream) {
        //     $this->navigation[$stream->id] = [
        //         'anchor' => [
        //             'text' => $stream->name(),
        //             'url' => URL::to(Arr::get($stream->ui, 'cp.section.url', 'admin/' . $stream->id)),
        //         ],
        //     ];
        // }
    }
}
