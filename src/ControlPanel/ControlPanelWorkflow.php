<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Str;
use Streams\Ui\Support\Normalizer;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\Component\Shortcut\Shortcut;
use Streams\Ui\ControlPanel\Component\Navigation\NavigationLink;

/**
 * Class ControlPanelWorkflow
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanelWorkflow extends Workflow
{

    protected $steps = [
        'control_panel' => self::class . '@buildControlPanel',
        'navigation' => self::class . '@buildNavigation',
        'shortcuts' => self::class . '@buildShortcuts',
    ];

    public function buildControlPanel(ControlPanelBuilder $builder)
    {
        $builder->instance = new ControlPanel();
    }

    public function buildNavigation(ControlPanelBuilder $builder)
    {
        $navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get()
            ->toArray();


        $navigation = Normalizer::fillWithAttribute($navigation, 'handle', 'id');
        $navigation = Normalizer::htmlAttributes($navigation);

        foreach ($navigation as $handle => &$item) {

            if (!isset($item['title'])) {
                $item['title'] = Str::title($handle);
            }
        }

        array_map(function ($attributes) use ($builder) {
            $builder->instance->navigation->put($attributes['handle'], new NavigationLink($attributes));
        }, $navigation);

        $builder->navigation = $navigation;
    }

    public function buildShortcuts(ControlPanelBuilder $builder)
    {
        $shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->toArray();

        $shortcuts = Normalizer::fillWithAttribute($shortcuts, 'handle', 'id');
        $shortcuts = Normalizer::htmlAttributes($shortcuts);

        array_map(function ($attributes) use ($builder) {
            $builder->instance->shortcuts->put($attributes['handle'], new Shortcut($attributes));
        }, $shortcuts);

        $builder->shortcuts = $shortcuts;
    }
}
