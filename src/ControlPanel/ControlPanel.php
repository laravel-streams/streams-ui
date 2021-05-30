<?php

namespace Streams\Ui\ControlPanel;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Button\ButtonCollection;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\Shortcut\ShortcutCollection;
use Streams\Ui\ControlPanel\Navigation\NavigationCollection;

class ControlPanel extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        $this->loadPrototypeProperties([
            'buttons' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ButtonCollection::class,
                ],
            ],
            'navigation' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => NavigationCollection::class,
                ],
            ],
            'shortcuts' => [
                'type' => 'collection',
                'config' => [
                    'abstract' => ShortcutCollection::class,
                ],
            ],
        ]);

        return parent::initializePrototypeAttributes(array_merge([
            'buttons' => [],
            'shortcuts' => [],
            'navigation' => [],
        ], $attributes));
    }

    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');
        
        $this->setPrototypeAttributes($attributes);

        //dd($this->buttons);
    }

    public function onInitialized()
    {
        $this->loadNavigation();
        $this->loadShortcuts();
    }

    public function loadNavigation()
    {
        $this->navigation = Streams::entries('cp.navigation')
            ->orderBy('sort_order', 'asc')
            ->orderBy('handle', 'asc')
            ->get();

        $match = null;

        $url = Request::fullUrl();

        $this->navigation->each(function ($link) use ($url, &$match) {

            if (!Str::startsWith($url, $link->url())) {
                return;
            }

            if ($match && strlen($link->url() > strlen($match->url()))) {
                $match = $link;
            }

            $match = $link;
        });

        if ($match && $match->parent) {

            if (!$parent = $this->navigation->first(function ($item) use ($match) {
                return $item->id == $match->parent;
            })) {
                throw new \Exception("Navigation [{$match->id}] parent [{$match->parent}] does not exist.");
            }

            $match->buttons = $match->buttons ?: $parent->buttons;
        }

        if ($match) {

            $match->active = true;

            $this->stream = $this->stream ?: $match->stream;
            $this->entry = $this->entry ?: $match->entry;
            
            if ($match->buttons) {
                $this->buttons = $match->buttons;
            }
        }
    }

    public function loadShortcuts()
    {
        $this->shortcuts = Streams::entries('cp.shortcuts')
            ->orderBy('sort_order', 'asc')
            ->get();
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

        return $this->setPrototypeAttributeValue('buttons', new ButtonCollection($buttons));
    }
}
