<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Support\Component;

class Admin extends Component
{
    public string $template = 'ui::components.admin';

    protected string $layout = 'ui::layouts.admin';

    public array $navigation = [];

    public function booted()
    {
        $streams = Streams::collection()->where('ui.cp.section', '!=', null);

        foreach ($streams as $stream) {
            $this->navigation[$stream->id] = [
                'text' => $stream->name(),
                'url' => Arr::get($stream->ui, 'cp.section.url', '/admin/' . $stream->id),
            ];
        }
    }
}
