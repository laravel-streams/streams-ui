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
    protected function initializeComponentPrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
            'buttons' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => ButtonCollection::class,
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

        Streams::collection()->filter(function ($stream) {
            return isset($stream->ui['cp']['section']);
        })->each(function ($stream) {

            $attributes = array_merge([
                'id' => $stream->handle,
            ], $stream->ui['cp']['section']);

            $this->navigation->add(new Section($attributes));
        });

        $this->navigation = $this->navigation->sortBy(function($section) {
            return (int) $section->sort_order ?: 0;
        });

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
