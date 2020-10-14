<?php

namespace Streams\Ui\ControlPanel\Component\Section;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\ControlPanel\ControlPanelBuilder;
use Streams\Ui\ControlPanel\Component\Navigation\NavigationLink;

/**
 * Class SectionInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionInput
{

    /**
     * Read the section input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     * @param NavigationLink $link
     */
    public static function read(ControlPanelBuilder $builder, NavigationLink $link)
    {
        self::resolve($builder, $link);
        self::normalize($builder);

        SectionGuesser::guess($builder);

        self::evaluate($builder, $link);
        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param ControlPanelBuilder $builder
     * @param NavigationLink $link
     */
    protected static function resolve(ControlPanelBuilder $builder, NavigationLink $link)
    {
        $sections = resolver($builder->getSections(), compact('builder', 'link'));

        $builder->setSections(evaluate($sections ?: $builder->getSections(), compact('builder', 'link')));
    }

    /**
     * Evaluate input.
     *
     * @param ControlPanelBuilder $builder
     * @param NavigationLink $link
     */
    protected static function evaluate(ControlPanelBuilder $builder, NavigationLink $link)
    {
        $builder->setSections(evaluate($builder->getSections(), compact('builder')));
    }

    /**
     * Normalize the section input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected static function normalize(ControlPanelBuilder $builder)
    {
        $sections = $builder->getSections();

        /*
         * Move child sections into main array.
         */
        foreach ($sections as $handle => &$section) {
            if (isset($section['sections'])) {
                foreach ($section['sections'] as $key => $child) {

                    /**
                     * It's a handle only!
                     */
                    if (is_string($child)) {

                        $key = $child;

                        $child = ['handle' => $child];
                    }

                    $child['parent'] = Arr::get($section, 'handle', $handle);
                    $child['handle']   = Arr::get($child, 'handle', $key);

                    $sections[$key] = $child;
                }
            }
        }

        /*
         * Loop over each section and make sense of the input
         * provided for the given module.
         */
        foreach ($sections as $handle => &$section) {

            /*
             * If the handle is not valid and the section
             * is a string then use the section as the handle.
             */
            if (is_numeric($handle) && is_string($section)) {
                $section = [
                    'handle' => $section,
                ];
            }

            /*
             * If the handle is a string and the title is not
             * set then use the handle as the handle.
             */
            if (is_string($handle) && !isset($section['handle'])) {
                $section['handle'] = $handle;
            }
        }

        $sections = Normalizer::attributes($sections);

        $builder->setSections(array_values($sections));
    }

    /**
     * Parse input.
     *
     * @param ControlPanelBuilder $builder
     * @param NavigationLink $link
     */
    protected static function parse(ControlPanelBuilder $builder)
    {
        $builder->setSections(Arr::parse($builder->getSections()));
    }

    /**
     * Translate input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected static function translate(ControlPanelBuilder $builder)
    {
        $builder->setSections(Translator::translate($builder->getSections()));
    }
}
