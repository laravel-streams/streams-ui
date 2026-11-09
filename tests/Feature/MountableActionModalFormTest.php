<?php

namespace Streams\Ui\Tests\Feature;

use Livewire\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Actions\MountableAction;

class MountableActionModalFormTest extends UiTestCase
{
    /** @test */
    public function modal_form_attaches_the_form(): void
    {
        $form = Form::make('modal');
        $action = MountableAction::make('create')->modalForm($form);

        $this->assertSame($form, $action->getForm());
    }

    /** @test */
    public function form_handle_validates_then_calls_mounted_action(): void
    {
        $livewire = new class extends Component
        {
            public array $data = [];

            public int $calls = 0;

            public function callMountedAction($arguments = [])
            {
                $this->calls++;

                return 'ran';
            }
        };

        $form = Form::for($livewire, 'modal')->submitsMountedAction();

        $this->assertSame('ran', $form->handle());
        $this->assertSame(1, $livewire->calls);
    }
}
