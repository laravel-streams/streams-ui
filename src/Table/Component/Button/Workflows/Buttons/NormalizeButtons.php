<?php

namespace Anomaly\Streams\Ui\Table\Component\Button\Workflows\Buttons;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Support\Normalizer;

/**
 * Class NormalizeButtons
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeButtons
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        foreach ($buttons as $handle => &$button) {

            /*
             * If the handle is numeric and the button is
             * a string then treat the string as both the
             * button and the handle. This is OK as long as
             * there are not multiple instances of this
             * input using the same button which is not likely.
             */
            if (is_numeric($handle) && is_string($button)) {
                $button = [
                    'handle' => $button,
                    'button' => $button,
                ];
            }

            /*
             * If the handle is NOT numeric and the button is a
             * string then use the handle as the handle and the
             * button as the button.
             */
            if (!is_numeric($handle) && is_string($button)) {
                $button = [
                    'handle' => $handle,
                    'button' => $button,
                ];
            }

            /*
             * If the handle is not numeric and the button is an
             * array without a handle then use the handle for
             * the handle for the button.
             */
            if (is_array($button) && !isset($button['handle']) && !is_numeric($handle)) {
                $button['handle'] = $handle;
            }

            /*
             * Make sure we have a button property.
             */
            if (is_array($button) && !isset($button['button'])) {
                $button['button'] = $button['handle'];
            }
        }

        $buttons = Normalizer::attributes($buttons);

        /**
         * Go back over and assume HREFs.
         * @todo rebutton this - from guesser
         */
        foreach ($buttons as $handle => &$button) {
            //
        }

        $builder->buttons = $buttons;
    }
}
