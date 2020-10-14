<?php

namespace Streams\Ui\ControlPanel\Component\Shortcut;

use Streams\Ui\ControlPanel\Component\Shortcut\Guesser\HrefGuesser;
use Streams\Ui\ControlPanel\Component\Shortcut\Guesser\PolicyGuesser;
use Streams\Ui\ControlPanel\Component\Shortcut\Guesser\TitleGuesser;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ShortcutGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutGuesser
{

    /**
     * Guess shortcut properties.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TitleGuesser::guess($builder);
        PolicyGuesser::guess($builder);
    }
}
