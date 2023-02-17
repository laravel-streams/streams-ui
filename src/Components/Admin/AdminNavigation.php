<?php

namespace Streams\Ui\Components\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Components\Navigation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;

class AdminNavigation extends Navigation
{
    public function booted()
    {
        $this->items = Config::get('streams.ui.admin.navigation', []);

        $streams = Streams::collection()->where('ui.admin.navigation', '!=', null);

        foreach ($streams as $stream) {
            foreach ($stream->ui['admin']['navigation'] as $item) {
                $this->items[] = $item;
            }
        }

        $this->items = Arr::sort($this->items, function ($item) {
            return $item['sort_order'] ?? 0;
        });

        $currentUrl = Request::url();

        $active = null;

        foreach ($this->items as $i => $item) {
            if ($currentUrl == URL::to($item['url'])) {
                $active = $i;
            }
        }

        if ($active === null) {
            foreach ($this->items as $i => $item) {
                if (Str::startsWith($currentUrl, URL::to($item['url']))) {
                    $active = $i;
                }
            }
        }

        if ($active !== null) {
            $this->items[$active]['active'] = true;
        }
    }
}
