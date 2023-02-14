<?php

namespace Streams\Ui\Components\Admin;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Navigation;
use Streams\Core\Support\Facades\Streams;

class AdminNavigation extends Navigation
{
    public function booted()
    {
        $streams = Streams::collection()->where('ui.admin.navigation', '!=', null);

        foreach ($streams as $stream) {
            foreach ($stream->ui['admin']['navigation'] as $item) {
                $this->items[] = $item;
            }
        }

        $this->items = Arr::sort($this->items, function ($item) {
            return $item['sort_order'] ?? 0;
        });
    }
}
