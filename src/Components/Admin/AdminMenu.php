<?php

namespace Streams\Ui\Components\Admin;

use Streams\Ui\Components\Menu;

class AdminMenu extends Menu
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
