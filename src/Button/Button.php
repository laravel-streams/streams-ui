<?php

namespace Streams\Ui\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button extends Component
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'component' => 'button',
            'template'  => 'ui::buttons.button',

            'tag'      => 'a',
            'url'      => null,
            'text'     => null,
            'entry'    => null,
            'policy'   => null,
            'enabled'  => true,
            'primary'  => false,
            'disabled' => false,
            'type'     => 'default',
            'classes'  => [
                'a-button',
            ],
            'attributes' => [],
        ], $attributes));
    }

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = [])
    {
        $attributes = Arr::htmlAttributes($this->attributes($attributes));

        return '<' . $this->tag . ' ' . $attributes . '>';
    }

    /**
     * Return the close tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->tag . '>';
    }

    /**
     * Return the button attributes array.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_filter(array_merge([
            'name'  => $this->name,
            'value' => $this->value,
            'class' => $this->class(),
            'href' => $this->url(),
        ], $attributes)));
    }

    public function url(array $extra = [])
    {
        if (!$target = Arr::get($this->attributes, 'href')) {
            return null;
        }

        if (Str::startsWith($target, '@cp/')) {
            return URL::cp(ltrim(substr($target, 4), '/'), $extra);
        }

        return URL::to($target, $extra);
    }

    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');

        $attributes = Arr::undot($attributes);

        $this->normalizeHtmlAttributes($attributes);
        $this->guessButtonInput($attributes);
        $this->mergeButtonInput($attributes);

        $callbackData->put('attributes', $attributes);
    }

    protected function normalizeHtmlAttributes(&$attributes)
    {

        /**
         * Make sure they exist.
         */
        $attributes['attributes'] = Arr::get($attributes, 'attributes', []);

        /**
         * Move the HREF if any to attributes.
         */
        if (isset($attributes['href'])) {
            Arr::set($attributes['attributes'], 'href', Arr::pull($attributes, 'href'));
        }

        /**
         * Move the URL if any to attributes.
         */
        if (isset($attributes['url'])) {
            Arr::set($attributes['attributes'], 'url', Arr::pull($attributes, 'url'));
        }

        /**
         * Move the target if any to attributes.
         */
        if (isset($attributes['target'])) {
            Arr::set($attributes['attributes'], 'target', Arr::pull($attributes, 'target'));
        }

        /**
         * Move all data-*|x-* keys to attributes.
         */
        foreach (array_keys($attributes) as $attribute) {
            if (Str::is(['data-*', 'x-*', '@*'], $attribute)) {
                Arr::set($attributes, 'attributes.' . $attribute, Arr::pull($attributes, $attribute));
            }
        }

        /**
         * Make sure the HREF is absolute.
         */
        if (
            isset($attributes['attributes']['href']) &&
            is_string($attributes['attributes']['href']) &&
            !Str::startsWith($attributes['attributes']['href'], ['http', '{', '//'])
        ) {
            $attributes['attributes']['href'] = url($attributes['attributes']['href']);
        }
    }

    protected function guessButtonInput(&$attributes)
    {

        /**
         * Default guesser for cancel button.
         */
        if (isset($attributes['button']) && $attributes['button'] == 'cancel' && !isset($attributes['attributes']['href']) && $attributes['stream']) {
            $attributes['attributes']['href'] = URL::route('ui::cp.index', ['section' => $attributes['stream']->handle]);
        }

        $attributes = Arr::parse($attributes, ['entry' => Arr::get($attributes, 'entry')]);
    }
    
    protected function mergeButtonInput(&$attributes)
    {

        $registry = app(ButtonRegistry::class);

        if ($registered = $registry->get(Arr::pull($attributes, 'button'))) {
            $attributes = array_replace_recursive($registered, $attributes);
        }
    }
}
