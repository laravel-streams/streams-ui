<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\Shortcut\ShortcutCollection;
use Streams\Ui\ControlPanel\Navigation\NavigationCollection;
use Streams\Ui\ControlPanel\Navigation\Section;

/**
 *
 * @typescript
 *
 */
class ControlPanel extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'buttons' => [
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
            'shortcuts' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ShortcutCollection::class,
                ],
            ],
        ]);

        return parent::initializeComponentPrototype(array_merge([
            'buttons' => [],
            'shortcuts' => [],
            'navigation' => [],
            'builder' => ControlPanelBuilder::class,
        ], $attributes));
    }

    public function setButtonsAttribute($buttons)
    {
        $buttons = $buttons ?: [];

        /**
         * Minimal standardization
         */
        array_walk($buttons, function (&$button, $key) {

            $button = is_string($button) ? [
                'button' => $button,
            ] : $button;

            $button['handle'] = Arr::get($button, 'handle', $key);

            $button['stream'] = $this->stream;

            if (!isset($button['attributes']['href'])) {
                $button['attributes']['href'] = URL::cp(Request::segment(2) . '/' . $button['handle']);
            }

            $button = new Button($button);
        });

        return $this->setPrototypeAttributeValue('buttons', new Collection($buttons));
    }
}
