<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Builders\Inputs\EditorInput;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Tests\UiTestCase;

class EditorInputTest extends UiTestCase
{
    protected function getTestInput(): EditorInput
    {
        return EditorInput::make('editor_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(EditorInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.editor', $input->getView());
    }

    /** @test */
    public function it_can_set_name()
    {
        $input = EditorInput::make('content');

        $this->assertEquals('content', $input->getName());
    }

    /** @test */
    public function it_can_set_label()
    {
        $input = $this->getTestInput();

        $input->label('Rich Text Content');

        $this->assertEquals('Rich Text Content', $input->getLabel());
    }
}
