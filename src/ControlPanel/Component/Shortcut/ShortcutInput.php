<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Shortcut;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator;
use Anomaly\Streams\Ui\Support\Normalizer;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ShortcutInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutInput
{

    /**
     * Read the shortcut input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function read(ControlPanelBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::normalize($builder);

        ShortcutGuesser::guess($builder);

        self::evaluate($builder);
        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function resolve(ControlPanelBuilder $builder)
    {
        $shortcuts = resolver($builder->getShortcuts(), compact('builder'));

        $builder->setShortcuts(evaluate($shortcuts ?: $builder->getShortcuts(), compact('builder')));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function evaluate(ControlPanelBuilder $builder)
    {
        $builder->setShortcuts(evaluate($builder->getShortcuts(), compact('builder')));
    }

    /**
     * Default input.
     *
     * @param \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function defaults(ControlPanelBuilder $builder)
    {
        // Defaults
        if (!$builder->getShortcuts()) {
            $builder->setShortcuts([
                'view_site' => [
                    'href'   => '/',
                    'class'  => 'button',
                    'target' => '_blank',
                    'title'  => 'anomaly.theme.flow::control_panel.view_site',
                ],
                'logout' => [
                    'class' => 'button',
                    'href'  => 'admin/logout',
                    'title' => 'anomaly.theme.flow::control_panel.logout',
                ],
            ]);
        }
    }

    /**
     * Normalize input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected static function normalize(ControlPanelBuilder $builder)
    {
        $shortcuts = $builder->getShortcuts();

        /*
         * Move child shortcuts into main array.
         */
        foreach ($shortcuts as $handle => &$shortcut) {
            if (isset($shortcut['shortcuts'])) {
                foreach ($shortcut['shortcuts'] as $key => $child) {

                    /**
                     * It's a handle only!
                     */
                    if (is_string($child)) {

                        $key = $child;

                        $child = ['handle' => $child];
                    }

                    $child['parent'] = Arr::get($shortcut, 'handle', $handle);
                    $child['handle']   = Arr::get($child, 'handle', $key);

                    $shortcuts[$key] = $child;
                }
            }
        }

        /*
         * Loop over each shortcut and make sense of the input
         * provided for the given module.
         */
        foreach ($shortcuts as $handle => &$shortcut) {

            /*
             * If the handle is not valid and the shortcut
             * is a string then use the shortcut as the handle.
             */
            if (is_numeric($handle) && is_string($shortcut)) {
                $shortcut = [
                    'handle' => $shortcut,
                ];
            }

            /*
             * If the handle is a string and the title is not
             * set then use the handle as the handle.
             */
            if (is_string($handle) && !isset($shortcut['handle'])) {
                $shortcut['handle'] = $handle;
            }
        }

        $shortcuts = Normalizer::attributes($shortcuts);

        $builder->setShortcuts(array_values($shortcuts));
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function parse(ControlPanelBuilder $builder)
    {
        $builder->setShortcuts(Arr::parse($builder->getShortcuts()));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function translate(ControlPanelBuilder $builder)
    {
        $builder->setShortcuts(Translator::translate($builder->getShortcuts()));
    }
}
