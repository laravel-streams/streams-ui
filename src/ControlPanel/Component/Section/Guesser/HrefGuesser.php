<?php

namespace Streams\Ui\ControlPanel\Component\Section\Guesser;

use Streams\Ui\ControlPanel\ControlPanelBuilder;

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
     * Guess the sections HREF attribute.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        if (!$module = app('module.collection')->active()) {
            return;
        }

        $sections = $builder->getSections();

        foreach ($sections as $index => &$section) {

            // If HREF is set then skip it.
            if (isset($section['attributes']['href'])) {
                continue;
            }

            $href = url('admin/' . $module->getHandle());

            if ($index !== 0 && $module->getHandle() !== $section['handle']) {
                $href .= '/' . $section['handle'];
            }

            $section['attributes']['href'] = $href;
        }

        $builder->setSections($sections);
    }
}
