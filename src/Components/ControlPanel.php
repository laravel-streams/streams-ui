<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Collection;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\ControlPanel\ControlPanelBuilder;
use Streams\Ui\Components\ControlPanel\Navigation\NavigationCollection;

class ControlPanel extends Component
{
    public Collection $buttons;
    public Collection $shortcuts;
    public NavigationCollection $navigation;

    public function initializeComponentPrototype(array $attributes = [])
    {
        $this->loadPrototypeProperties([
            'buttons' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'shortcuts' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ],
            'navigation' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => NavigationCollection::class,
                ],
            ],
        ]);

        return parent::initializeComponentPrototype(array_merge([
            'component' => 'cp',
            'template'  => 'ui::components.cp.cp',

            'buttons' => [],
            'shortcuts' => [],
            'navigation' => [],
            'builder' => ControlPanelBuilder::class,
        ], $attributes));
    }
}
