<?php

namespace Streams\Ui\Builders\Modals;

use Streams\Ui\Builders\Actions\Action;

/**
 * Default header "X" control for modals.
 *
 * Icon-only; style via CloseAction::configureUsing() or Modal closeAction() customization.
 * Does not inherit the modal shell radius — icon-only controls stay rounded-full by default.
 */
class CloseAction extends Action
{
    public function __construct(string $name = 'close')
    {
        parent::__construct($name);

        $this
            ->label(false)
            ->icon('heroicon-o-x-mark')
            ->iconSize('sm')
            ->color('black')
            ->borderRadius('full')
            ->size('md')
            ->htmlAttributes([
                'type' => 'button',
                'tabindex' => '-1',
                'class' => 'ui-modal-close-btn',
                'aria-label' => 'Close',
                'x-on:click' => 'close()',
            ]);
    }

    public static function make(?string $name = null): static
    {
        $static = new static($name ?? 'close');

        $static->configure();

        return $static;
    }
}
