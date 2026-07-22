<?php

namespace Streams\Ui\Tests\Builders\Forms;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Forms\Form;

class FormDirectionTest extends UiTestCase
{
    /** @test */
    public function it_defaults_to_column_direction(): void
    {
        $form = Form::make('example');

        $this->assertTrue($form->isColumnDirection());
        $this->assertSame('col', $form->getDirection());
    }

    /** @test */
    public function it_can_use_row_direction(): void
    {
        $form = Form::make('tags')->direction('row');

        $this->assertFalse($form->isColumnDirection());
        $this->assertSame('row', $form->getDirection());
    }
}
