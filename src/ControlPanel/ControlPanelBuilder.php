<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Str;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanel;
use Streams\Ui\ControlPanel\Navigation\Section;

class ControlPanelBuilder extends Workflow
{
    public array $steps = [
        'load_navigation' => self::class . '@loadNavigation',
        'load_shortcuts' => self::class . '@loadShortcuts',
    ];

    public function loadNavigation(ControlPanel $component)
    {
        $component->navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get();

        Streams::collection()->filter(function ($stream) use ($component) {
            return isset($stream->ui['cp']['section']);
        })->each(function ($stream) {

            $attributes = array_merge([
                'id' => $stream->handle,
            ], $stream->ui['cp']['section']);

            $component->navigation->add(new Section($attributes));
        });

        $component->navigation = $component->navigation->sortBy(function($section) {
            return (int) $section->sort_order ?: 0;
        });

        $match = null;

        $url = Request::fullUrl();

        $component->navigation->each(function ($link) use ($url, &$match) {

            if (!Str::startsWith($url, $link->url())) {
                return;
            }

            if ($match && strlen($link->url() > strlen($match->url()))) {
                $match = $link;
            }

            $match = $link;
        });

        if ($match && $match->parent) {

            if (!$parent = $component->navigation->first(function ($item) use ($match) {
                return $item->id == $match->parent;
            })) {
                throw new \Exception("Navigation [{$match->id}] parent [{$match->parent}] does not exist.");
            }

            $match->buttons = $match->buttons ?: $parent->buttons;
        }

        if ($match) {

            $match->active = true;

            $component->stream = $component->stream ?: $match->stream;
            $component->entry = $component->entry ?: $match->entry;

            if ($match->buttons) {
                $component->buttons = $match->buttons;
            }
        }
    }

    public function loadShortcuts(ControlPanel $component)
    {
        $component->shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get();
    }
}
