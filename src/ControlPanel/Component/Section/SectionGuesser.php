<?php

namespace Streams\Ui\ControlPanel\Component\Section;

use Streams\Ui\ControlPanel\Component\Section\Guesser\DescriptionGuesser;
use Streams\Ui\ControlPanel\Component\Section\Guesser\HrefGuesser;
use Streams\Ui\ControlPanel\Component\Section\Guesser\PolicyGuesser;
use Streams\Ui\ControlPanel\Component\Section\Guesser\TitleGuesser;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionGuesser
{

    /**
     * Guess section properties.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TitleGuesser::guess($builder);
        PolicyGuesser::guess($builder);
        DescriptionGuesser::guess($builder);
    }
}
