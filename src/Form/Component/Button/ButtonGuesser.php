<?php

namespace Streams\Ui\Form\Component\Button;

use Streams\Ui\Form\Component\Button\Guesser\DisabledGuesser;
use Streams\Ui\Form\Component\Button\Guesser\EnabledGuesser;
use Streams\Ui\Form\Component\Button\Guesser\HrefGuesser;
use Streams\Ui\Form\Component\Button\Guesser\TextGuesser;
use Streams\Ui\Form\FormBuilder;

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
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        HrefGuesser::guess($builder);
        TextGuesser::guess($builder);
        EnabledGuesser::guess($builder);
        DisabledGuesser::guess($builder);
    }
}
