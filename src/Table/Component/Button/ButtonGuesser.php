<?php

namespace Streams\Ui\Table\Component\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Table\Component\Button\Guesser\HrefGuesser;
use Streams\Ui\Table\Component\Button\Guesser\TextGuesser;
use Streams\Ui\Table\Component\Button\Guesser\PolicyGuesser;
use Streams\Ui\Table\Component\Button\Guesser\EnabledGuesser;

/**
 * Class ButtonGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonGuesser
{

    /**
     * Guess button properties.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        self::guessHref($builder);
        self::guessText($builder);
        self::guessPolicy($builder);
        self::guessEnabled($builder);
    }

    /**
     * Guess the HREF for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guessHref(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        $stream = $builder->stream;

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            /**
             * If a route has been defined then
             * move that to an HREF closure.
             */
            if (isset($button['route']) && $builder->stream) {

                $button['attributes']['href'] = function ($entry) use ($button) {

                    /* @var EntryInterface $entry */
                    return $entry->route($button['route']);
                };

                continue;
            }

            switch (Arr::get($button, 'button')) {

                case 'restore':

                    $button['attributes']['href'] = url(
                        'entry/handle/restore/' . $stream->location . '/' . $stream->handle . '/{entry.id}'
                    );

                    break;

                default:

                    // Determine the HREF based on the button type.
                    $type = Arr::get($button, 'segment', Arr::get($button, 'button'));

                    if ($type && !Str::contains($type, '\\') && !class_exists($type)) {
                        $button['attributes']['href'] = request()->url() . '/' . $type . '/{entry.id}';
                    }

                    break;
            }
        }

        $builder->buttons = $buttons;
    }

    /**
     * Guess the text for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guessText(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        if (!$module = app('module.collection')->active()) {
            return;
        }

        foreach ($buttons as &$button) {

            // Skip if set already.
            if (!isset($button['text']) && isset($button['handle'])) {
                $button['text'] = $module->getNamespace('button.' . $button['handle']);
            }
        }

        $builder->buttons = $buttons;
    }

    /**
     * Guess the text for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guessPolicy(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        if (!$module = app('module.collection')->active()) {
            return;
        }

        if (!$stream = $builder->stream) {
            return;
        }

        foreach ($buttons as &$button) {
            if (isset($button['ability'])) {
                continue;
            }

            /*
             * Try and guess the ability value.
             * @todo mention of abilitys can pry go - use policies and gates.
             */
            switch (Arr::get($button, 'button')) {

                case 'update':
                    $button['ability'] = $module->getNamespace($stream->handle . '.write');
                    break;

                default:
                    $button['ability'] = $module->getNamespace(
                        $stream->handle . '.' . Arr::get($button, 'handle')
                    );
                    break;
            }
        }

        $builder->buttons = $buttons;
    }

    /**
     * Guess the HREF for a button.
     *
     * @param TableBuilder $builder
     */
    public static function guessEnabled(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        foreach ($buttons as &$button) {

            if (($policy = Arr::get($button, 'policy')) && !Gate::any((array) $policy)) {
                $button['enabled'] = false;
            }
        }

        $builder->buttons = $buttons;
    }
}
