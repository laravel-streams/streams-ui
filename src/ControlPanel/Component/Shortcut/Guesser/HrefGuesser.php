<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Shortcut\Guesser;

use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class HrefGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HrefGuesser
{

    /**
     * Guess the shortcuts HREF attribute.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        if (!$module = app('module.collection')->active()) {
            return;
        }

        $shortcuts = $builder->getShortcuts();

        foreach ($shortcuts as $index => &$shortcut) {

            // If HREF is set then skip it.
            if (isset($shortcut['attributes']['href'])) {
                continue;
            }

            $href = url('admin/' . $module->getHandle());

            if ($index !== 0 && $module->getHandle() !== $shortcut['handle']) {
                $href .= '/' . $shortcut['handle'];
            }

            $shortcut['attributes']['href'] = $href;
        }

        $builder->setShortcuts($shortcuts);
    }
}
