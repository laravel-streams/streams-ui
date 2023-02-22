<?php

namespace Streams\Ui\Components\Admin\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Components\Navigation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;

class NavigationBuilder extends Workflow
{
    public array $steps = [
        'load_ui_config' => self::class . '@loadUiConfig',
        'load_streams_config' => self::class . '@loadStreamsConfig',
        'sort_items' => self::class . '@sortItems',
        'detect_active_item' => self::class . '@detectActiveItem',
    ];

    public function loadUiConfig(Navigation $component): void
    {
        $component->items = Config::get('streams.ui.admin.navigation', []);
    }

    public function loadStreamsConfig(Navigation $component): void
    {
        $streams = Streams::collection()->where('ui.admin.navigation', '!=', null);
        
        foreach ($streams as $stream) {
            foreach (Arr::get($stream->ui, 'admin.navigation', []) as $item) {
                $component->items[] = $item;
            }
        }
    }
    
    public function sortItems(Navigation $component): void
    {
        $component->items = Arr::sort($component->items, function ($item) {
            return Arr::get($item, 'sort_order', 1);
        });
    }
    
    public function detectActiveItem(Navigation $component): void
    {
        $currentUrl = Request::url();

        $active = null;

        foreach ($component->items as $i => $item) {
            if ($currentUrl == URL::to($item['url'])) {
                $active = $i;
            }
        }

        if ($active === null) {
            foreach ($component->items as $i => $item) {
                if (Str::startsWith($currentUrl, URL::to($item['url']))) {
                    $active = $i;
                }
            }
        }

        if ($active !== null) {
            $component->items[$active]['active'] = true;
        }
    }
}
