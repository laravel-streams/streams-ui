<?php

namespace Streams\Ui\Tests\Builders\Modals;

use Streams\Ui\Builders\Modals\CloseAction;
use Streams\Ui\Builders\Modals\Modal;
use Streams\Ui\Tests\UiTestCase;

class CloseActionTest extends UiTestCase
{
    /** @test */
    public function it_defaults_to_an_icon_only_close_control(): void
    {
        $action = CloseAction::make();

        $this->assertFalse($action->getLabel());
        $this->assertSame('heroicon-o-x-mark', $action->getIcon());
        $this->assertSame('sm', $action->getIconSize());
        $this->assertSame('black', $action->getColor());
        $this->assertSame('full', $action->getBorderRadius());

        $html = $action->toHtml();

        $this->assertStringContainsString('ui-modal-close-btn', $html);
        $this->assertStringContainsString('x-on:click="close()"', $html);
        $this->assertStringContainsString('aria-label="Close"', $html);
        $this->assertStringContainsString('rounded-full', $html);
    }

    /** @test */
    public function it_can_be_styled_via_configure_using(): void
    {
        CloseAction::configureUsing(
            function (CloseAction $action): void {
                $action->color('light');
            },
            during: function (): void {
                $action = CloseAction::make();

                $this->assertSame('light', $action->getColor());
                $this->assertStringContainsString('bg-gray-200', $action->toHtml());
            },
        );
    }

    /** @test */
    public function modal_close_action_can_be_customized_or_hidden(): void
    {
        $modal = Modal::make('demo');

        $this->assertNotNull($modal->getCloseAction());
        $this->assertInstanceOf(CloseAction::class, $modal->getCloseAction());

        $styled = Modal::make('styled')
            ->closeAction(fn (CloseAction $action) => $action->color('primary'));

        $this->assertSame('primary', $styled->getCloseAction()->getColor());

        $hidden = Modal::make('hidden')->closeAction(false);

        $this->assertNull($hidden->getCloseAction());
        $this->assertFalse($hidden->hasCloseAction());
    }
}
