<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\MarkdownInput;
use Streams\Ui\Tests\UiTestCase;

class MarkdownInputTest extends UiTestCase
{
    protected function getTestInput(): MarkdownInput
    {
        return MarkdownInput::make('markdown_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(MarkdownInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::components.inputs.markdown', $input->getView());
    }

    /** @test */
    public function it_can_set_label()
    {
        $input = $this->getTestInput();

        $input->label('Markdown Content');

        $this->assertEquals('Markdown Content', $input->getLabel());
    }
}
