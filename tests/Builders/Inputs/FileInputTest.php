<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\FileInput;

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

    /** @test */
    public function it_resolves_explicit_preview_url_for_images(): void
    {
        $input = FileInput::make('avatar')
            ->image()
            ->previewUrl('https://cdn.example.com/avatars/me.jpg');

        $this->assertSame('https://cdn.example.com/avatars/me.jpg', $input->getPreviewUrl());
        $this->assertTrue($input->shouldShowImagePreview());
        $this->assertSame('image/*', $input->getAccept());
    }

    /** @test */
    public function it_shows_filename_for_non_image_paths_without_image_preview(): void
    {
        $livewire = new class extends \Livewire\Component
        {
            public array $data = [
                'file_field' => 'docs/handbook.pdf',
            ];

            public function render()
            {
                return '<div></div>';
            }
        };

        $input = FileInput::make('file_field')
            ->livewire($livewire)
            ->statePath('data.file_field');

        $this->assertSame('handbook.pdf', $input->getCurrentFileName());
        $this->assertFalse($input->shouldShowImagePreview());
        $this->assertStringContainsString('handbook.pdf', $input->getPreviewUrl() ?? '');
    }

    /** @test */
    public function it_shows_image_preview_for_stored_image_paths(): void
    {
        $livewire = new class extends \Livewire\Component
        {
            public array $data = [
                'avatar' => 'avatars/ryan.png',
            ];

            public function render()
            {
                return '<div></div>';
            }
        };

        $input = FileInput::make('avatar')
            ->disk('public')
            ->livewire($livewire)
            ->statePath('data.avatar');

        $this->assertSame('ryan.png', $input->getCurrentFileName());
        $this->assertTrue($input->shouldShowImagePreview());
        $this->assertNotNull($input->getPreviewUrl());
    }
}
