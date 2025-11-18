<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Builders\Inputs\FileInput;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Tests\UiTestCase;

class FileInputTest extends UiTestCase
{
    protected function getTestInput(): FileInput
    {
        return FileInput::make('file_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(FileInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.file', $input->getView());
    }

    /** @test */
    public function it_can_set_name()
    {
        $input = FileInput::make('document_upload');

        $this->assertEquals('document_upload', $input->getName());
    }

    /** @test */
    public function it_can_set_label()
    {
        $input = $this->getTestInput();

        $input->label('Upload Document');

        $this->assertEquals('Upload Document', $input->getLabel());
    }
}
