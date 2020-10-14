<?php

namespace Streams\Ui\Form\Component\Field;

use Streams\Ui\Form\Component\Field\Guesser\DisabledGuesser;
use Streams\Ui\Form\Component\Field\Guesser\EnabledGuesser;
use Streams\Ui\Form\Component\Field\Guesser\InstructionsGuesser;
use Streams\Ui\Form\Component\Field\Guesser\LabelsGuesser;
use Streams\Ui\Form\Component\Field\Guesser\PlaceholdersGuesser;
use Streams\Ui\Form\Component\Field\Guesser\PrefixesGuesser;
use Streams\Ui\Form\Component\Field\Guesser\ReadOnlyGuesser;
use Streams\Ui\Form\Component\Field\Guesser\RequiredGuesser;
use Streams\Ui\Form\Component\Field\Guesser\TranslatableGuesser;
use Streams\Ui\Form\Component\Field\Guesser\UniqueGuesser;
use Streams\Ui\Form\Component\Field\Guesser\WarningsGuesser;
use Streams\Ui\Form\Component\Field\Guesser\NullableGuesser;
use Streams\Ui\Form\FormBuilder;

class FieldGuesser
{

    /**
     * Guess field input.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        LabelsGuesser::guess($builder);
        UniqueGuesser::guess($builder);
        EnabledGuesser::guess($builder);
        WarningsGuesser::guess($builder);
        PrefixesGuesser::guess($builder);
        RequiredGuesser::guess($builder);
        NullableGuesser::guess($builder);
        DisabledGuesser::guess($builder);
        ReadOnlyGuesser::guess($builder);
        TranslatableGuesser::guess($builder);
        InstructionsGuesser::guess($builder);
        PlaceholdersGuesser::guess($builder);
    }
}
